<template>
    <CardModal>
        <div slot="header" class="has-margin-0">
            {{ isCreate ? 'Create' : 'Edit' }} Tutorial
        </div>
        <div slot="body">
            <BaseTextField
                label="Name"
                v-model="updatedTutorial.name"
                placeholder="First timers"
            ></BaseTextField>
            <BaseTextArea
                label="Description (Optional)"
                v-model="updatedTutorial.description"
                placeholder="Tutorial for first time customers."
            ></BaseTextArea>
        </div>
        <div
            slot="footer"
            class="has-margin-0"
        >
            <BaseButton
                @click="onSaveClick"
                is-success
            >
                {{ isCreate ? 'Create' : 'Save' }}
            </BaseButton>
            <BaseButton
                @click="onCancelClick"
            >
                Cancel
            </BaseButton>
        </div>
    </CardModal>
</template>
<script>
    import BaseButton from '../atoms/BaseButton'
    import BaseTextField from '../atoms/BaseTextField'
    import BaseTextArea from '../atoms/BaseTextArea'
    import CardModal from '../molecules/CardModal'

    export default {
        props: {
            tutorial: {
                type: Object,
                default: null,
            },
        },
        data() {
            return {
                isCreate: true,
                updatedTutorial: {
                    name: '',
                    description: '',
                },
            };
        },
        methods: {
            onCancelClick() {
                this.$emit('cancelClick');
                this.clear()
            },
            onSaveClick() {
                this.$emit('saveClick', this.updatedTutorial)
                this.clear()
            },
            clear() {
                this.updatedTutorial = {
                    name: '',
                    description: '',
                };
            },
        },
        watch: {
            tutorial: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.isCreate = false;
                        this.updatedTutorial = { ...value }
                    } else {
                        this.clear();
                    }
                },
            },
        },
        components: {
            BaseButton,
            BaseTextField,
            BaseTextArea,
            CardModal,
        }
    }

</script>