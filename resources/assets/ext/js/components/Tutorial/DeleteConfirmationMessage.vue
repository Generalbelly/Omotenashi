<template>
    <BaseMessage
            header="Delete Tutorial"
            :message-classes="['is-danger', 'is-fixed-bottom-right']"
            @closeClick="$emit('closeClick')"
    >
        <template slot="body">
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
                            v-model="tutorialName"
                    >
                </p>
            </div>
            <div class="field">
                <button
                        class="button is-danger is-outlined is-fullwidth"
                        :disabled="tutorialName === '' || tutorialName != selectedTutorial.name"
                        @click="$emit('deleteClick')"
                >
                    DELETE
                </button>
            </div>
        </template>
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
                tutorialName: '',
            }
        },
        watch: {
            selectedTutorial() {
                this.tutorialName = ''
            }
        },
    }
</script>
