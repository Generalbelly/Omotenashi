<template>
    <div>
        <form-section-layout>
            <template slot="form">
                <validatable-text-field
                    label="Name"
                    v-model="innerName"
                    placeholder="First timers"
                    name="name"
                    rules="required"
                >
                </validatable-text-field>
                <validatable-textarea-field
                    label="Description"
                    v-model="innerDescription"
                    placeholder="Tutorial for first time customers."
                    name="description"
                >
                </validatable-textarea-field>
            </template>
        </form-section-layout>
        <form-section-layout>
            <template slot="form">
                <columns
                    v-if="innerPath.regex"
                    class="path-regex-value"
                >
                    <div>
                        {{ origin }}
                    </div>
                    <div>
                        <validatable-text-field
                            label="Start this tutorial for a user visiting the following url path."
                            :value="innerPath.value"
                            @input="updateInnerPath('value', $event)"
                            name="regex"
                            :rules="innerPath.regex ? 'required' : ''"
                        ></validatable-text-field>
                    </div>
                    <div>
                        {{ formatParameters(innerParameters) }}
                    </div>
                </columns>
                <columns v-else>
                    <column>
                        <textarea-field
                            label="Start this tutorial for a user visiting the following url path."
                            row="3"
                            :value="path.value+formatParameters(innerParameters)"
                            disabled
                        ></textarea-field>
                    </column>
                </columns>
                <columns v-if="innerPath.value !== '/'">
                    <column>
                        <checkbox
                            :value="innerPath.regex"
                            @input="updateInnerPath('regex', $event)"
                        >
                            Use regular expression
                        </checkbox>
                    </column>
                </columns>
                <columns>
                    <column>
                        <checkbox v-model="withParameters">
                            with parameters
                        </checkbox>
                    </column>
                </columns>
                <parameter-fields
                    v-show="withParameters"
                    v-model="innerParameters"
                >
                </parameter-fields>
            </template>
        </form-section-layout>
    </div>
</template>

<script>
    import ValidatableTextField from "../../../molecules/fields/ValidatableTextField";
    import TutorialSettingFields from "../../../molecules/fields/TutorialSettingFields";
    import FormSectionLayout from "../../../layouts/FormSectionLayout/FormSectionLayout";
    import Columns from "../../../atoms/Columns";
    import Column from "../../../atoms/Column";
    import ParameterFields from "../../../molecules/fields/ParameterFields";
    import TextField from "../../../atoms/fields/TextField/TextField";
    import Checkbox from "../../../atoms/fields/Checkbox/Checkbox";
    import ValidatableTextareaField from "../../../molecules/fields/ValidatableTextareaField";
    import TextareaField from "../../../atoms/fields/TextareaField";

    export default {
        name: "TutorialForm",
        components: {
            TextareaField,
            ValidatableTextareaField,
            Checkbox,
            TextField,
            ParameterFields,
            Column,
            Columns,
            FormSectionLayout,
            TutorialSettingFields,
            ValidatableTextField,
        },
        props: {
            id: {
                type: String,
                default: null,
            },
            name: {
                type: String,
                default: null,
            },
            description: {
                type: String,
                default: null,
            },
            path: {
                type: Object,
                default() {
                    return {}
                },
            },
            parameters: {
                type: Array,
                default() {
                    return []
                }
            },
        },
        data() {
            return {
                withParameters: false,
            };
        },
        computed: {
            innerName: {
                get() {
                    return this.name
                },
                set(newValue) {
                    this.$emit('update:name', newValue)
                }
            },
            innerDescription: {
                get() {
                    return this.description
                },
                set(newValue) {
                    this.$emit('update:description', newValue)
                }
            },
            innerParameters: {
                get() {
                    this.withParameters = this.parameters.length > 0
                    return this.parameters
                },
                set(newValue) {
                    this.$emit('update:parameters', newValue)
                }
            },
            innerPath: {
                get() {
                    return this.path
                },
                set(newValue) {
                    this.$emit('update:path', newValue)
                }
            },

        },
        watch: {
            withParameters(value) {
                if (value && this.innerParameters.length === 0) {
                    this.innerParameters = [
                        {
                            key: '',
                            value: '',
                        }
                    ]
                }
            },
        },
        methods: {
            updateInnerPath(key, value) {
                this.innerPath = {
                    ...this.innerPath,
                    [key]: value,
                }
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
            }
        }
    }
</script>

<style scoped>

</style>