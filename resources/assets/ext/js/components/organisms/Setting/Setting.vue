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
            <div>
                Show this tutorial for a user visiting the following url.
                <BaseTextField
                    :value="updatedTutorial.url"
                    name="url"
                    v-validate="'required'"
                    :error-messages="errors.collect('url')"
                    disabled
                ></BaseTextField>
                <BaseCheckBox
                    v-model="showParameterFields"
                >
                    with parameters
                </BaseCheckBox>
                <template v-if="showParameterFields">
                    <div
                        v-for="(p, pIndex) in updatedTutorial.parameters"
                        :key="pIndex"
                        class="parameter"
                        :class="{ 'has-margin-top-4': pIndex === 0 }"
                    >
                        <BaseTextField
                            label="Key"
                            v-model="p.key"
                            v-validate="{'required': showParameterFields}"
                            :error-messages="errors.collect('parameter key')"
                            name="parameter key"
                        ></BaseTextField>
                        <BaseTextField
                            label="Value"
                            v-model="p.value"
                            v-validate="{'required': showParameterFields}"
                            :error-messages="errors.collect('parameter value ')"
                            name="parameter value"
                        ></BaseTextField>
                        <BaseIcon
                            icon="trash"
                            class="parameter__trash has-cursor-pointer"
                            @click="deleteParameter(p.id)"
                        ></BaseIcon>
                    </div>
                    <div class="has-margin-top-1">
                        <BaseButton
                            is-text
                            @click="addParameter"
                        >
                            Add another parameter
                        </BaseButton>
                    </div>
                </template>
            </div>
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
    import uuidv4 from 'uuid'
    import BaseIcon from '../../../../../js/components/atoms/BaseIcon'
    import BaseButton from '../../../../../js/components/atoms/BaseButton'
    import BaseTextField from '../../../../../js/components/atoms/BaseTextField'
    import BaseTextArea from '../../../../../js/components/atoms/BaseTextArea'
    import CardModal from '../../../../../js/components/molecules/CardModal'
    import BaseCheckBox from "../../../../../js/components/atoms/BaseCheckBox"

    export default {
        name: 'Setting',
        components: {
            BaseCheckBox,
            BaseButton,
            BaseTextField,
            BaseTextArea,
            CardModal,
            BaseIcon,
        },
        props: {
            tutorial: {
                type: Object,
                default: null,
            },
        },
        data() {
            return {
                isCreate: true,
                updatedTutorial: null,
                showParameterFields: false,
            };
        },
        watch: {
            tutorial: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.isCreate = false;
                        this.updatedTutorial = this.createTutorial(value);
                    } else {
                        this.setInitialTutorial();
                    }
                },
            },
            'updatedTutorial.parameters': {
                deep: true,
                handler(newValue, oldValue) {
                    if (newValue.length === 0 && oldValue.length > 0) {
                        this.showParameterFields = false
                    }
                    this.updatedTutorial.url = this.getUrl() + this.formatParameters(this.updatedTutorial.parameters)
                }
            },
            showParameterFields(value){
                if (value && this.updatedTutorial.parameters.length === 0) {
                    this.addParameter()
                }
            },
        },
        methods: {
            getUrl() {
                return window.location.href
            },
            formatParameters(params) {
                return params.reduce((total, current, index) => {
                    if (current.key && current.value) {
                        if (index === 0) {
                            return `?${total}${current.key}=${current.value}`
                        } else {
                            return `${total}&${current.key}=${current.value}`
                        }
                    } else {
                        return total;
                    }
                }, '');
            },
            createTutorial(defaultValues={}) {
                return {
                    name: '',
                    description: '',
                    url: '',
                    parameters: [],
                    ...defaultValues,
                };
            },
            onCancelClick() {
                this.$emit('cancelClick')
                this.setInitialTutorial()
            },
            onSaveClick() {
                return new Promise((resolve, reject) => {
                    this.$validator.validateAll()
                        .then(result => {
                            console.log(result)
                            if (result) {
                                this.$emit('saveClick', this.updatedTutorial)
                                this.setInitialTutorial()
                                resolve()
                            }
                        })
                        .catch(() => {
                            reject()
                        })
                });
            },
            setInitialTutorial() {
                this.updatedTutorial = this.createTutorial({
                    url: this.getUrl(),
                });
            },
            addParameter() {
                this.updatedTutorial.parameters = [
                    ...this.updatedTutorial.parameters,
                    {
                        id: uuidv4(),
                        key: '',
                        value: '',
                    }
                ]
            },
            deleteParameter(id) {
                const index = this.updatedTutorial.parameters.findIndex(p => p.id === id)
                this.updatedTutorial.parameters = [
                    ...this.updatedTutorial.parameters.slice(0, index),
                    ...this.updatedTutorial.parameters.slice(index+1),
                ];
            }
        }
    }

</script>

<style scoped>
    .parameter {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        grid-column-gap: .5em;
    }
    .parameter__trash {
        height: 100% !important;
    }
</style>