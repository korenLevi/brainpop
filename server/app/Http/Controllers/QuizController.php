<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Get quiz with all questions and answers.
     * 
     * Returns all questions with their answers (without revealing which is correct).
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuiz()
    {
        $questions = Question::with(['answers' => function ($query) {
            $query->orderBy('order');
        }])
        ->orderBy('order')
        ->get()
        ->map(function ($question) {
            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'order' => $question->order,
                'answers' => $question->answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'answer_text' => $answer->answer_text,
                        'order' => $answer->order,
                    ];
                }),
            ];
        });

        return response()->json([
            'questions' => $questions,
        ], 200);
    }

    /**
     * Store user answers.
     * 
     * Sample Request Payload:
     * {
     *     "answers": [
     *         {"question_id": 1, "answer_id": 2},
     *         {"question_id": 2, "answer_id": 5},
     *         ...
     *     ]
     * }
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUserAnswers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);
        // dd(validator);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();

        // Delete existing answers for this user (to allow resubmission)
        UserAnswer::where('user_id', $user->id)->delete();

        // Store new answers
        $answers = [];
        foreach ($request->answers as $answerData) {
            $answers[] = [
                'user_id' => $user->id,
                'question_id' => $answerData['question_id'],
                'answer_id' => $answerData['answer_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        UserAnswer::insert($answers);
        
        return $this->getUserAnswers();
    }

    /**
     * Get user answers with results.
     * 
     * Returns the user's answers along with whether they were correct or not,
     * and the overall score.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAnswers()
    {
        $user = Auth::user();

        $userAnswers = UserAnswer::where('user_id', $user->id)
            ->with(['question', 'answer'])
            ->get();

        if ($userAnswers->isEmpty()) {
            return response()->json([
                'message' => 'No answers found for this user',
                'answers' => [],
                'score' => 0,
                'total_questions' => Question::count(),
            ], 200);
        }

            $results = $userAnswers->map(function ($userAnswer) {
            $isCorrect = $userAnswer->answer->is_correct;
            
            return [
                'question_id' => $userAnswer->question_id,
                'question_text' => $userAnswer->question->question_text,
                'selected_answer_id' => $userAnswer->answer_id,
                'is_correct' => $isCorrect,
            ];
        });

        $totalQuestions = Question::count();
        $correctAnswers = $results->where('is_correct', true)->count();
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        return response()->json([
            'answers' => $results,
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
        ], 200);
    }
}
