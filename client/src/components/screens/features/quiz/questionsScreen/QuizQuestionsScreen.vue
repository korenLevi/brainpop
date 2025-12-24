<template>

  <form class="questions_container" @submit.prevent="submit">
    <QuizQuestion :question="questions[currentQuestionIndex]" :selectedAnswerId="selectedAnswers[currentQuestionIndex]?.answer_id" @select-answer="selectAnswer" />
    <QuizPagination :showPreviousButton="currentQuestionIndex !== 0"
      :showNextButton="currentQuestionIndex !== questions.length - 1" :currentQuestionIndex="currentQuestionIndex"
      :questionsLength="questions.length" :previousButtonDisabled="previousButtonDisabled"
      :nextButtonDisabled="nextButtonDisabled" @previous-question="previousQuestion" @next-question="nextQuestion">
      <template v-if="currentQuestionIndex === questions.length - 1" #customButtons>
        <BaseButton type="submit" :disabled="loading">
          {{ loading ? 'Submitting...' : 'Submit' }}
        </BaseButton>
      </template>
    </QuizPagination>
  </form>

</template>

<script>
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
import Navigator from '@/components/compositions/navigator/Navigator.vue'
import QuizQuestion from './QuizQuestion.vue'
import QuizPagination from './QuizPagination.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'
export default {
  name: 'QuizQuestionsScreen',
  components: { BackgroundWave, Navigator, QuizQuestion, QuizPagination, BaseButton },
  emit: ['submitQuestions'],
  props: {
    questions: {
      type: Array,
      required: true
    },
    selectedAnswers: {
      type: Array,
      default: [],
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      currentQuestionIndex: 0,
    }
  },
  methods: {
    submit() {
      this.$emit('submitQuestions', this.selectedAnswers)
    },
    previousQuestion() {
      this.currentQuestionIndex--
    },
    nextQuestion() {
      this.currentQuestionIndex++
    },
    selectAnswer(answerId) {
      const answerObject = {
        question_id: this.questions[this.currentQuestionIndex].id,
        answer_id: answerId
      }

      this.$emit('selectAnswer', answerObject, this.currentQuestionIndex)
    },
  },
  computed: {
    previousButtonDisabled() {
      return this.currentQuestionIndex === 0
    },
    nextButtonDisabled() {
      return this.currentQuestionIndex === this.questions.length - 1 || !this.selectedAnswers[this.currentQuestionIndex]
    }
  }
}
</script>

<style lang="scss" scoped>
.questions_container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px 20px;
  max-width: 800px;
  margin: 0 auto;
  gap: 10px;
}
</style>
