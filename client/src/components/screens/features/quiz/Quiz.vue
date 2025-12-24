<template>
  <BackgroundWave />
  <div v-if="data">
    <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="data.name" :questionsLength="data.questions.length"
      @start="start" />
    <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS" :questions="data.questions"
      @selectAnswer="selectAnswer" :selectedAnswers="selectedAnswers" :loading="loading"
      @submitQuestions="submitQuestions"></QuizQuestionsScreen>
    <QuizSummary v-if="quizState === QUIZ_STATES.RESULT" :questions="data.questions" :summary="data.summary"
      @startAgain="startAgain" />
  </div>
  <div v-else>Loading...</div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'
import QuizSummary from './QuizSummary.vue'
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
const QUIZ_STATES = {
  START: 'start',
  QUESTIONS: 'questions',
  RESULT: 'result'
}

export default {
  name: 'Quiz',
  emits: ['submitQuestions'],
  components: {
    BackgroundWave,
    QuizStartScreen,
    QuizQuestionsScreen,
    QuizSummary
  },
  props: {
    data: {
      type: Object,
      required: false
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      QUIZ_STATES,
      quizState: QUIZ_STATES.START,
      selectedAnswers: [],
    }
  },
  methods: {
    start() {
      this.quizState = QUIZ_STATES.QUESTIONS
    },
    submitQuestions() {
      this.$emit('submitQuestions', this.selectedAnswers)
    },
    selectAnswer(answer, index) {
      this.selectedAnswers[index] = answer
    },
    startAgain() {
      this.quizState = QUIZ_STATES.START
      this.selectedAnswers = []
      this.data.summary = null
    }
  },
  watch: {
    'data.summary'(newVal) {
      if (newVal) {
        this.quizState = QUIZ_STATES.RESULT
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
</style>
