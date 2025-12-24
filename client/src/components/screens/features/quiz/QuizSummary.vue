<template>
    <div class="quiz_result_container">
        <h1>Quiz Result</h1>
        <p>Your score is {{ summary.score }}%</p>
        <p>You got {{ summary.correct_answers }} out of {{ summary.total_questions }} questions correct</p>

        <div class="questions_container">
            <QuizQuestionResult v-for="question in questions" :key="question.id" :question="question"
                :selectedAnswer="getAnswerForQuestion(question.id)" />
        </div>
        <BaseButton :theme="BUTTON_THEMES.PRIMARY" @click="startAgain">Start Again</BaseButton>
    </div>
</template>
<script>
// CONFIGURATIONS
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'

// COMPONENTS
import QuizQuestion from './questionsScreen/QuizQuestion.vue'
import QuizQuestionResult from './questionsScreen/QuizQuestionResult.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'

export default {
    name: 'QuizSummary',
    emits: ['startAgain'],
    components: {
        QuizQuestion,
        QuizQuestionResult,
        BaseButton
    },
    data() {
        return {
            BUTTON_THEMES
        }
    },
    props: {
        questions: {
            type: Array,
            required: true
        },
        summary: {
            type: Object,
            required: true
        }
    },
    methods: {
        getAnswerForQuestion(questionId) {
            return this.summary.answers.find(answer => answer.question_id === questionId)
        },
        startAgain() {
            this.$emit('startAgain')
        }
    }
}
</script>
<style lang="scss" scoped>
.quiz_result_container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
}

.questions_container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 35px;
}
</style>