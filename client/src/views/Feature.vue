<template>
  <div class="feature_container">
    <component v-if="supportedFeatures[featureType]" :data="data" :loading="loading" :is="featureType"
      @submitQuestions="submitQuestions" />
    <span v-else>{{ featureType }} feature is NOT supported YET</span>
  </div>
</template>

<script>
// FEATURE TYPES
import Quiz from '@/components/screens/features/quiz/Quiz.vue'
import { useUserStore } from '@/stores/user'
export default {
  name: 'Feature',
  components: {
    Quiz
  },
  data() {
    return {
      supportedFeatures: {
        quiz: true
      },
      featureType: 'quiz',
      data: null,
      loading: false,
    }
  },
  // In this case we are calling this View Feature which means that we can use this dynamic cmp to multiple features. but here we are calling to fetch the data for the quiz feature.
  // So I think we need to fetch the data for the quiz feature in the  Quiz.vue cmp.
  async mounted() {
    const store = useUserStore()
    await store.fetchQuestions()

    this.data = {
      name: 'Test Quiz',
      questions: store.questions,
    }
  },
  methods: {
    async submitQuestions(selectedAnswers) {
      this.loading = true
      try {
        const store = useUserStore()
        this.data.summary = await store.submitQuestions(selectedAnswers)
      } catch (error) {
        console.error('Error submitting questions:', error)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

