<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question_text' => 'What is the capital of France?',
                'answers' => [
                    ['answer_text' => 'London', 'is_correct' => false],
                    ['answer_text' => 'Berlin', 'is_correct' => false],
                    ['answer_text' => 'Paris', 'is_correct' => true],
                    ['answer_text' => 'Madrid', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which planet is known as the Red Planet?',
                'answers' => [
                    ['answer_text' => 'Venus', 'is_correct' => false],
                    ['answer_text' => 'Mars', 'is_correct' => true],
                    ['answer_text' => 'Jupiter', 'is_correct' => false],
                    ['answer_text' => 'Saturn', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'What is 2 + 2?',
                'answers' => [
                    ['answer_text' => '3', 'is_correct' => false],
                    ['answer_text' => '4', 'is_correct' => true],
                    ['answer_text' => '5', 'is_correct' => false],
                    ['answer_text' => '6', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Who wrote "Romeo and Juliet"?',
                'answers' => [
                    ['answer_text' => 'Charles Dickens', 'is_correct' => false],
                    ['answer_text' => 'William Shakespeare', 'is_correct' => true],
                    ['answer_text' => 'Jane Austen', 'is_correct' => false],
                    ['answer_text' => 'Mark Twain', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'What is the largest ocean on Earth?',
                'answers' => [
                    ['answer_text' => 'Atlantic Ocean', 'is_correct' => false],
                    ['answer_text' => 'Indian Ocean', 'is_correct' => false],
                    ['answer_text' => 'Arctic Ocean', 'is_correct' => false],
                    ['answer_text' => 'Pacific Ocean', 'is_correct' => true],
                ],
            ],
            [
                'question_text' => 'What is the chemical symbol for water?',
                'answers' => [
                    ['answer_text' => 'H2O', 'is_correct' => true],
                    ['answer_text' => 'CO2', 'is_correct' => false],
                    ['answer_text' => 'NaCl', 'is_correct' => false],
                    ['answer_text' => 'O2', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'In which year did World War II end?',
                'answers' => [
                    ['answer_text' => '1943', 'is_correct' => false],
                    ['answer_text' => '1944', 'is_correct' => false],
                    ['answer_text' => '1945', 'is_correct' => true],
                    ['answer_text' => '1946', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'What is the smallest prime number?',
                'answers' => [
                    ['answer_text' => '0', 'is_correct' => false],
                    ['answer_text' => '1', 'is_correct' => false],
                    ['answer_text' => '2', 'is_correct' => true],
                    ['answer_text' => '3', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which programming language is known as the "language of the web"?',
                'answers' => [
                    ['answer_text' => 'Python', 'is_correct' => false],
                    ['answer_text' => 'Java', 'is_correct' => false],
                    ['answer_text' => 'JavaScript', 'is_correct' => true],
                    ['answer_text' => 'C++', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'What is the speed of light in vacuum?',
                'answers' => [
                    ['answer_text' => '300,000 km/s', 'is_correct' => true],
                    ['answer_text' => '150,000 km/s', 'is_correct' => false],
                    ['answer_text' => '450,000 km/s', 'is_correct' => false],
                    ['answer_text' => '200,000 km/s', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questions as $index => $questionData) {
            $question = Question::create([
                'question_text' => $questionData['question_text'],
                'order' => $index + 1,
            ]);

            foreach ($questionData['answers'] as $answerIndex => $answerData) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerData['answer_text'],
                    'is_correct' => $answerData['is_correct'],
                    'order' => $answerIndex + 1,
                ]);
            }
        }
    }
}
