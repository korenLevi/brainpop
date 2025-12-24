<template>
  <form class="login_form" @submit.prevent="submit">
    <BaseInput v-model="email" label="Email" type="email" />
    <BaseInput v-model="password" label="Password" type="password" />
    <BaseButton type="submit" fullWidth :disabled="loading" >
      {{ loading ? 'Loading...' : 'Log in' }}</BaseButton>
    <span v-if="errorMessage" class="error_message">
    {{ errorMessage }}
    </span>
  </form>
</template>

<script>
// COMPONENTS
import BaseInput from '@/components/base/input/BaseInput.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'

export default {
  name: 'LoginForm',
  emits: ['submit'],
  components: {
    BaseInput,
    BaseButton
  },
  props: {
    errorMessage: {
      type: String,
      required: false
    },
    loading: {
      type: Boolean,
      required: false
    }
  },
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    submit() {
      this.$emit('submit', {
        email: this.email,
        password: this.password
      })
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
.login_form {
  width: 60%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  color: $ESSENTIALS_BLUE2;
  margin-block-start: 50px;
}
.error_message {
  color: red;
}
</style>
