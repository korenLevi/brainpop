<template>
    <div class="quiz_pagination" :style="{ justifyContent: showPreviousButton ? 'space-between' : 'flex-end' }">
        <BaseButton class="previous-button" v-if="showPreviousButton" @click="previousQuestion" :disabled="previousButtonDisabled">
            {{ previousButtonTitle }}</BaseButton>
        <BaseButton class="next-button" v-if="showNextButton" @click="nextQuestion" :disabled="nextButtonDisabled" >{{ nextButtonTitle }}
        </BaseButton>
        <slot name="customButtons"></slot>
    </div>
</template>
<script>
import BaseButton from '@/components/base/button/BaseButton.vue'
export default {
    name: 'QuizPagination',
    components: { BaseButton },
    props: {
        currentQuestionIndex: {
            type: Number,
            required: true
        },
        questionsLength: {
            type: Number,
            required: true
        },
        previousButtonTitle: {
            type: String,
            default: 'Previous',
        },
        nextButtonTitle: {
            type: String,
            default: 'Next',
        },
        previousButtonDisabled: {
            type: Boolean,
            default: false
        },
        nextButtonDisabled: {
            type: Boolean,
            default: false
        },
        showNextButton: {
            type: Boolean,
            default: true
        },
        showPreviousButton: {
            type: Boolean,
            default: true
        }
    },
    methods: {
        previousQuestion() {
            this.$emit('previous-question')
        },
        nextQuestion() {
            this.$emit('next-question')
        }
    }
}
</script>
<style lang="scss" scoped>
.quiz_pagination {
    background: teal;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 12px 0;
    display: flex;
    gap: 0.5rem;
    display: flex;
    justify-content: space-between;
    color: white;
}
.next-button{
    margin-right: 10px;
}

.previous-button{
    margin-left: 10px;
}
</style>