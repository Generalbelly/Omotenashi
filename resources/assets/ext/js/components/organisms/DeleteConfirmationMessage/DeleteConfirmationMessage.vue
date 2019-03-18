<template>
    <message
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
            <text-field v-model="tutorialName"></text-field>
            <div class="field">
                <base-button
                    is-danger
                    is-outlined
                    is-fullwidth
                    @click="onDeleteClick"
                    :disabled="isButtonDisabled"
                >
                    DELETE
                </base-button>
            </div>
        </template>
    </message>
</template>
<script>
    import Message from '../../molecules/Message'
    import BaseButton from '../../atoms/BaseButton'
    import TextField from "../../molecules/fields/TextField";

    export default {
        name: 'DeleteConfirmationMessage',
        components: {
            TextField,
            Message,
            BaseButton,
        },
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
                return (this.tutorialName === '' || this.tutorialName !== this.tutorial.name)
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
        }
    }
</script>