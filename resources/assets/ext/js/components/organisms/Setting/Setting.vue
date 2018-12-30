<template>
    <CardModal>
        <div slot="header" class="has-margin-0">
            <base-header>{{ isCreate ? 'Create' : 'Edit' }} Tutorial</base-header>
        </div>
        <div slot="body">
            <validation-observer ref="observer">
                <div slot-scope="{invalid}">
                    <validatable-text-field
                        label="Name"
                        v-model="updatedTutorial.name"
                        placeholder="First timers"
                        name="name"
                        rules="required"
                    >
                    </validatable-text-field>
                    <validatable-textarea-field
                        label="Description (Optional)"
                        v-model="updatedTutorial.description"
                        placeholder="Tutorial for first time customers."
                        name="description"
                        rules="required"
                    >
                    </validatable-textarea-field>
                    <div>
                        Show this tutorial for a user visiting the following url.
                        <text-field
                            :value="updatedTutorial.url"
                            name="url"
                            rules="required"
                            disabled
                        ></text-field>
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
                                <validatable-text-field
                                    label="Key"
                                    v-model="p.key"
                                    :rules="showParameterFields ? 'required' : ''"
                                    name="parameter key"
                                ></validatable-text-field>
                                <validatable-text-field
                                    label="Value"
                                    v-model="p.value"
                                    :rules="showParameterFields ? 'required' : ''"
                                    name="parameter value"
                                ></validatable-text-field>
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
            </validation-observer>
        </div>
        <div
            slot="footer"
            class="has-margin-0"
        >
            <BaseButton
                @click="onSaveClick"
                is-primary
            >
                {{ isCreate ? 'Create' : 'Save' }}
            </BaseButton>
            <BaseButton
                @click="onCancelClick"
                is-text
            >
                Cancel
            </BaseButton>
        </div>
    </CardModal>
</template>
<script>
    import { ValidationObserver } from 'vee-validate'
    import uuidv4 from 'uuid'
    import BaseIcon from '../../atoms/BaseIcon'
    import BaseButton from '../../atoms/BaseButton'
    import CardModal from '../../molecules/CardModal'
    import BaseCheckBox from "../../atoms/BaseCheckBox"
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField";
    import TextField from "../../molecules/fields/TextField";
    import ValidatableTextareaField from "../../molecules/fields/ValidatableTextareaField";
    import BaseHeader from "../../atoms/BaseHeader/BaseHeader";

    export default {
        name: 'Setting',
        components: {
            BaseHeader,
            ValidationObserver,
            ValidatableTextareaField,
            ValidatableTextField,
            TextField,
            BaseCheckBox,
            BaseButton,
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
                        this.clear();
                    }
                },
            },
            'updatedTutorial.parameters': {
                deep: true,
                handler(newValue, oldValue) {
                    if (newValue.length === 0 && oldValue.length > 0) {
                        this.showParameterFields = false
                    }
                    this.updateUrl()
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
                return this.tutorial ? this.tutorial.url : window.location.href
            },
            updateUrl() {
                this.updatedTutorial.url = this.getUrl() + this.formatParameters(this.updatedTutorial.parameters)
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
                this.clear()
            },
            onSaveClick() {
                this.$refs.observer.validate()
                    .then(result => {
                        console.log(result);
                        if (result) {
                            this.$emit('saveClick', this.updatedTutorial)
                            this.clear()
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            clear() {
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
            },
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
        align-items: flex-end !important;
        margin-top: calc(17px + 0.5em) !important;
    }
</style>