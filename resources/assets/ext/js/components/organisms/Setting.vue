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
                name="name"
                v-validate="'required'"
                :error-messages="errors.collect('name')"
            ></BaseTextField>
            <BaseTextArea
                label="Description (Optional)"
                v-model="updatedTutorial.description"
                placeholder="Tutorial for first time customers."
                name="description"
                v-validate="'required'"
                :error-messages="errors.collect('description')"
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
    import BaseButton from '../../../../js/components/atoms/BaseButton'
    import BaseTextField from '../../../../js/components/atoms/BaseTextField'
    import BaseTextArea from '../../../../js/components/atoms/BaseTextArea'
    import CardModal from '../../../../js/components/molecules/CardModal'

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
                return new Promise((resolve, reject) => {
                    this.$validator.validateAll()
                        .then(result => {
                            console.log(result)
                            if (result) {
                                this.$emit('saveClick', this.updatedTutorial)
                                this.clear()
                                resolve()
                            }
                        })
                        .catch(() => {
                            reject()
                        })
                });
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