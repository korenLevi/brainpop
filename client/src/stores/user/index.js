import { defineStore } from 'pinia'
import api from '@/services/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    loggedIn: false,
    questions: [],
    selectedAnswers: [],
    summary: null,
  }),
  getters: {
    isLoggedIn: state => {
      const token = window.localStorage.getItem('auth_token')
      return !!token || state.loggedIn
    },
    getQuestions: state => {
      return state.questions
    },
    getSelectedAnswers: state => {
      return state.selectedAnswers
    },
    getSummary: state => {
      return state.summary
    },
  },
  actions: {
    async fetchQuestions() {
      try {
        const response = await api.get('/quiz')
        this.questions = response.data.questions
      } catch (error) {
        console.error('Get questions error:', error)
        throw error
      }
    },
    async submitQuestions(selectedAnswers) {
      try {
        const response = await api.post('/quiz/answers', {
          answers: selectedAnswers
        })
        this.summary = response.data
        return response.data;
      } catch (error) {
        console.error('Submit questions error:', error)
        throw error
      }
    },
    async login(credentials, callback) {
      try {
        const response = await api.post('/login', {
          email: credentials.email || credentials.userName,
          password: credentials.password
        })
        
        const { access_token } = response.data
        
        // Store token in localStorage
        window.localStorage.setItem('auth_token', access_token)
        window.localStorage.setItem('loggedIn', 'true')
        this.loggedIn = true
        
        // ACTIVATE CALLBACK WITH THE LOGIN STATUS
        if (callback) callback(true)
      } catch (error) {
        // ACTIVATE CALLBACK WITH THE LOGIN STATUS
        if (callback) callback(false)
        throw error
      }
    },
    async logout() {
      try {
        await api.post('/logout')
      } catch (error) {
        // Even if logout fails on server, clear local storage
        console.error('Logout error:', error)
      } finally {
        // Clear local storage
        window.localStorage.removeItem('auth_token')
        window.localStorage.removeItem('loggedIn')
        this.loggedIn = false
      }
    }
  }
})
