<template>
    <Message
        :is-fixed-top-right="false"
        is-fixed-bottom-right
        is-danger
        @closeClick="$emit('closeClick')"
    >
        <template slot="header">
            Delete Tutorial
        </template>
        <template slot="body">
            <p
                v-if="tutorial"
                class="has-padding-top-1 has-padding-bottom-4"
            >
                You are about to delete "{{ tutorial.name }}".<br/>
                Please type in the name of the tutorial to confirm.
            </p>
            <BaseTextField
                v-model="tutorialName"
            >
            </BaseTextField>
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
        </template>
    </Message>
</template>
<script>
    import Message from '../../../../../js/components/molecules/Message'
    import BaseButton from '../../atoms/BaseButton'
    import BaseTextField from '../../atoms/BaseTextField'

    export default {
        name: 'DeleteConfirmationMessage',
        props: {
            tutorial: {
                type: Object,
                default: null,
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
                this.$emit('deleteClick', this.tutorial.id);
            }
        },
        components: {
            Message,
            BaseButton,
            BaseTextField,
        }
    }
</script>