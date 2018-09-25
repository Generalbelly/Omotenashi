<template>
    <BaseMessage
        header="Delete Tutorial"
        class="message-container"
        is-fixed-bottom-right
        is-danger
        @closeClick="$emit('closeClick')"
    >
        <BaseMessageHeader></BaseMessageHeader>
        <BaseMessageBody>
            <p class="has-padding-top-1 has-padding-bottom-4">
                Your are about to delete "{{ tutorial.name }}".<br/>
                Please type in the name of the tutorial to confirm.
            </p>
            <base-text-field
                v-model="tutorialName"
            >
            </base-text-field>
            <div class="field">
                <BaseButton
                    is-danger
                    is-outlined
                    is-fullwidth
                    @click="onDeleteClick"
                    :disabled="isButtonDisabled"
                >
                    DELETE
                </BaseButton>
            </div>
        </BaseMessageBody>
    </BaseMessage>
</template>
<script>
    import BaseMessage from '../BaseMessage'
    import BaseMessageHeader from '../BaseMessageHeader'
    import BaseMessageBody from '../BaseMessageBody'
    import BaseButton from '../BaseButton'
    import BaseTextField from '../BaseTextField'

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
            },
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
            BaseMessageHeader,
            BaseMessageBody,
            BaseButton,
            BaseTextField,
        }
    }
</script>

<style>
    .message-container > .message {
        min-width: 30vw;
        max-width: 50vw;
    }
</style>
<style scoped>
    .message-container {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 10000000000;
    }
</style>
