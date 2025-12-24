<template>
    <div class="quiz_question">
        <div class="question_header">
            <h3> {{ question.order }} </h3>
            <h4>{{ question.question_text }}</h4>

        </div>
        <div class="answers">
            <div class="answer" :class="{ 'selected': selectedAnswerId === answer.id }"
                v-for="(answer, index) in question.answers" :key="answer.id" @click="selectAnswer(answer.id)">
                <input type="radio" :id="answer.id" :name="question.id" :value="answer.id" hidden>
                <span class="answer-letter" :class="{ 'selected-letter': selectedAnswerId === answer.id }">
                    {{ String.fromCharCode(65 + index) }}
                </span>
                <label :for="answer.id">{{ answer.answer_text }}</label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'QuizQuestion',
    emits: ['select-answer'],
    data() {
        return {
            selectedAnswer: null
        }
    },
    props: {
        question: {
            type: Object,
            required: true
        },
        isSummary: {
            type: Boolean,
            default: false
        },
        selectedAnswerId: {
            type: Number,
            default: null
        }
    },
    methods: {
        selectAnswer(answerId) {
            this.$emit('select-answer', answerId)
        }
    }

}
</script>
<style lang="scss">
@import '@/utilities/css/vars/vars.scss';

.question_header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quiz_question {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.answers {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.answer {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid $LIGHT_GRAY;
    background: $WHITE;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    width: 450px;
}

.answer-letter {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid $BLACK;
    color: $BLACK;
    display: flex;

    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.selected-letter {
    background: $MONTE_CARLO;
    color: $WHITE;
    border: 2px solid $TEAL;
}

.selected {
    background: $LIGHT_BACKGROUND;
    border: 2px solid $BLUE_1;
}
</style>