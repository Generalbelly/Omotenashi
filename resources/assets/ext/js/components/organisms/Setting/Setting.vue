<template>
    <CardModal>
        <div slot="header" class="is-marginless">
            <base-header
                :level="3"
                class="has-text-left"
            >
                {{ !!tutorial ? 'Edit' : 'Create' }} Tutorial
            </base-header>
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
                        <base-check-box
                            v-model="showParameterFields"
                        >
                            with parameters
                        </base-check-box>
                        <template v-if="showParameterFields">
                            <div class="parameter__labels">
                                <base-label>Key</base-label>
                                <base-label>Value</base-label>
                            </div>
                            <div
                                v-for="(p, pIndex) in updatedTutorial.parameters"
                                :key="pIndex"
                                class="parameter__input"
                            >
                                <validatable-text-field
                                    :value="p.key"
                                    @input="updateParameter(pIndex, { key: $event} )"
                                    :rules="showParameterFields ? 'required' : ''"
                                    name="parameter key"
                                    class="is-marginless"
                                ></validatable-text-field>
                                <validatable-text-field
                                    :value="p.value"
                                    @input="updateParameter(pIndex, { value: $event })"
                                    :rules="showParameterFields ? 'required' : ''"
                                    name="parameter value"
                                    class="is-marginless"
                                ></validatable-text-field>
                                <base-icon
                                    icon="trash"
                                    class="has-cursor-pointer"
                                    @click="deleteParameter(pIndex)"
                                ></base-icon>
                            </div>
                            <div class="has-margin-top-1">
                                <base-button
                                    @click="addParameter"
                                    is-text
                                >
                                    Add another parameter
                                </base-button>
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
            <base-button
                @click="onSaveClick"
                is-primary
            >
                {{ !!tutorial ? 'Save' : 'Create' }}
            </base-button>
            <base-button
                @click="onCancelClick"
                class="is-text"
            >
                Cancel
            </base-button>
        </div>
    </CardModal>
</template>
<script>
    import { ValidationObserver } from 'vee-validate'
    import BaseIcon from '../../atoms/BaseIcon'
    import BaseButton from '../../atoms/BaseButton'
    import CardModal from '../../molecules/CardModal'
    import BaseCheckBox from "../../atoms/BaseCheckBox"
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField";
    import TextField from "../../molecules/fields/TextField";
    import ValidatableTextareaField from "../../molecules/fields/ValidatableTextareaField";
    import BaseHeader from "../../atoms/BaseHeader";
    import BaseLabel from "../../atoms/BaseLabel";
    import TutorialEntity from "../../../../../js/components/atoms/Entities/TutorialEntity";

    export default {
        name: 'Setting',
        components: {
            BaseLabel,
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
                updatedTutorial: null,
                showParameterFields: false,
            };
        },
        watch: {
            tutorial: {
                immediate: true,
                handler(value) {
                    if (value) {
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
                    } else if (newValue.length > 0) {
                        this.showParameterFields = true
                    }
                    // this.updatedTutorial.url = this.updatedTutorial.urlPath + this.formatParameters(this.updatedTutorial.parameters)
                }
            },
            showParameterFields(value){
                if (value && this.updatedTutorial.parameters.length === 0) {
                    this.addParameter()
                }
            },
        },
        methods: {
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
                return new TutorialEntity(defaultValues);
            },
            onCancelClick() {
                this.$emit('cancelClick')
                this.clear()
            },
            onSaveClick() {
                this.$refs.observer.validate()
                    .then(result => {
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
                this.updatedTutorial = this.createTutorial();
            },
            addParameter() {
                this.updatedTutorial.parameters = [
                    ...this.updatedTutorial.parameters,
                    {
                        key: '',
                        value: '',
                    }
                ]
            },
            updateParameter(index, value) {
                this.updatedTutorial.parameters = [
                    ...this.updatedTutorial.parameters.slice(0, index),
                    {
                        ...this.updatedTutorial.parameters[index],
                        ...value,
                    },
                    ...this.updatedTutorial.parameters.slice(index+1),
                ]
            },
            deleteParameter(index) {
                this.updatedTutorial.parameters = [
                    ...this.updatedTutorial.parameters.slice(0, index),
                    ...this.updatedTutorial.parameters.slice(index+1),
                ];
            },
        }
    }

</script>

<style scoped>
    .parameter__labels {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-top: 10px;
    }
    .parameter__input {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        grid-column-gap: .5em;
        align-items: center;
        margin-bottom: 10px;
    }
</style>