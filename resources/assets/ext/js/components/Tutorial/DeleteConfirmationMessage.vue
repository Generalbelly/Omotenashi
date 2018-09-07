<template>
    <BaseMessage
            header="Delete Tutorial"
            :message-class="['is-danger', 'is-fixed-bottom-right']"
            @closeClick="$emit('closeClick')"
    >
        <p class="has-padding-top-1 has-padding-bottom-4">
            Your are about to delete "{{ selectedTutorial.name }}".<br/>
            Please type in the name of the tutorial to confirm.
        </p>
        <div class="field">
            <p class="control">
                <input
                    class="input"
                    type="text"
                    placeholder="Tutorial name"
                    v-model="tutorialNameToDelete"
                >
            </p>
        </div>
        <div class="field">
            <button
                class="button is-danger is-outlined is-fullwidth"
                :disabled="tutorialNameToDelete === '' || tutorialNameToDelete != selectedTutorial.name"
                @click="$emit('deleteClick')"
            >
                DELETE
            </button>
        </div>
    </BaseMessage>
</template>
<script>
    import BaseMessage from '../BaseMessage'

    export default {
        name: 'DeleteConfirmationMessage',
        components: {BaseMessage},
        props: {
            selectedTutorial: {
                type: Object,
                default() {
                    return {}
                }
            },
        },
        data() {
            return {
                tutorialNameToDelete: '',
            }
        },
        watch: {
            selectedTutorial() {
                this.tutorialNameToDelete = ''
            }
        },
    }
</script>
