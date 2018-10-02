<template>
    <BaseModalCard>
        <BaseModalCardHeader>
            {{ isCreate ? 'Create' : 'Edit' }} Tutorial
        </BaseModalCardHeader>
        <BaseModalCardBody>
            <BaseTextField
                label="Name"
                v-model="updatedTutorial.name"
                placeholder="First timers"
            ></BaseTextField>
            <BaseTextArea
                label="Description (Optional)"
                v-model="updatedTutorial.description"
                placeholder="Tutorial for the first time customers."
            ></BaseTextArea>
        </BaseModalCardBody>
        <BaseModalCardFooter>
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
        </BaseModalCardFooter>
    </BaseModalCard>
</template>
<script>
    import BaseButton from '../atoms/BaseButton'
    import BaseTextField from '../atoms/BaseTextField'
    import BaseTextArea from '../atoms/BaseTextArea'
    import BaseModalCard from '../atoms/BaseCardModal'
    import BaseModalCardHeader from '../atoms/BaseCardModalHeader'
    import BaseModalCardBody from '../atoms/BaseCardModalBody'
    import BaseModalCardFooter from '../atoms/BaseCardModalFooter'

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
            BaseModalCard,
            BaseModalCardHeader,
            BaseModalCardBody,
            BaseModalCardFooter,
        }
    }

</script>