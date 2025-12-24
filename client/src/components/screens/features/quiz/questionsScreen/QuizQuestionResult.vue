<template>
    <div>
        <div class="question_header">
            <h3> {{ question.order }} </h3>
            <h4>{{ question.question_text }}</h4>

        </div>
        <div class="answers">
            <div class="answer_container" v-for="(answer, index) in question.answers" :key="answer.id">
                <div class="answer" :class="getAnswerClass(answer)">
                    <input type="radio" disabled :id="answer.id" :name="question.id" :value="answer.id" hidden>
                    <span class="answer-letter"
                        :class="{ 'selected-letter': selectedAnswer && selectedAnswer.selected_answer_id === answer.id }">
                        {{ String.fromCharCode(65 + index) }}
                    </span>
                    <label :for="answer.id">{{ answer.answer_text }}</label>
                </div>
                <template v-if="answer.id === selectedAnswer.selected_answer_id">
                    <CheckCircle v-if="selectedAnswer.is_correct" class="icon correct-icon" />
                    <TimesCircle v-else class="icon incorrect-icon" />
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import CheckCircle from '@/assets/check_circle.svg?component'
import TimesCircle from '@/assets/times_circle.svg?component'
export default {
    name: 'QuizQuestionResult',
    components: {
        CheckCircle,
        TimesCircle
    },
    props: {
        question: {
            type: Object,
            required: true
        },
        selectedAnswer: {
            type: Object,
            required: false,
            default: null
        }
    },
    methods: {
        getAnswerClass(answer) {
            if (!this.selectedAnswer) return ''
            if (this.selectedAnswer.selected_answer_id === answer.id) {
                return this.selectedAnswer.is_correct ? 'correct' : 'incorrect'
            }
            return ''
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.answer_container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.correct {
    background: $GREEN_CHECK_MARK;
    color: $WHITE;
    border: 2px solid $FIELD_GREEN;
}

.incorrect {
    background: $ERROR_MESSAGE;
    color: $WHITE;
}

.icon {
    width: 20px;
    height: 20px;
}

.correct-icon {
    color: $GREEN_CHECK_MARK;
}

.incorrect-icon {
    color: $ERROR_MESSAGE;
}
</style>
