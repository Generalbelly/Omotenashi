<template>
    <BaseMessage
        header="Delete Tutorial"
        :message-classes="['is-danger', 'is-fixed-bottom-right']"
        @closeClick="$emit('closeClick')"
    >
        <template slot="body">
            <p class="has-padding-top-1 has-padding-bottom-4">
                Your are about to delete "{{ tutorial.name }}".<br/>
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
                <BaseButton
                    :classes="['is-danger', 'is-outlined', 'is-fullwidth']"
                    @click="onDeleteClick"
                    :disabled="isButtonDisabled"
                >
                    DELETE
                </BaseButton>
            </div>
        </template>
    </BaseMessage>
</template>
<script>
    import BaseMessage from '../BaseMessage'
    import BaseButton from '../BaseButton'

    export default {
        name: 'DeleteConfirmationMessage',
        props: {
            tutorial: {
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
        computed: {
            isButtonDisabled() {
                return (this.tutorialName === '' || this.tutorialName != this.tutorial.name)
            }
        },
        watch: {
            tutorial() {
                this.tutorialName = ''
            }
        },
        methods: {
            onDeleteClick() {
                this.$emit('deleteClick');
            }
        },
        components: {
            BaseMessage,
            BaseButton,
        }
    }
</script>
