<template>
    <CardModal>
        <div slot="header" class="is-marginless">
            <base-header
                :level="3"
                class="has-text-left"
            >
                {{ id ? 'Edit' : 'Create' }} Tutorial
            </base-header>
        </div>
        <div slot="body">
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
            <div>
                <div class="has-padding-bottom-4">
                    Start this tutorial for a user visiting the following url.
                </div>
                <columns
                    v-if="innerPath.regex"
                    class="path-regex-value"
                >
                    <div>
                        {{ origin }}
                    </div>
                    <div>
                        <text-field
                            :value="innerPath.value"
                            @input="updateInnerPath('value', $event)"
                            name="regex"
                            :rules="innerPath.regex ? 'required|' : ''"
                        ></text-field>
                    </div>
                    <div>
                        {{ formatParameters(innerParameters) }}
                    </div>
                </columns>
                <columns v-else>
                    <column>
                        <textarea-field
                            row="3"
                            :value="origin+path.value+formatParameters(innerParameters)"
                            disabled
                        ></textarea-field>
                    </column>
                </columns>
                <columns v-if="innerPath.value !== '/'">
                    <column>
                        <base-check-box
                            :value="innerPath.regex"
                            @input="updateInnerPath('regex', $event)"
                        >
                            Use regular expression
                        </base-check-box>
                    </column>
                </columns>
                <columns>
                    <column>
                        <base-check-box
                            v-model="withParameters"
                        >
                            with parameters
                        </base-check-box>
                    </column>
                </columns>
                <parameter-fields
                    v-show="withParameters"
                    v-model="innerParameters"
                >
                </parameter-fields>
            </div>
        </div>
        <div
            slot="footer"
            class="has-margin-0"
        >
            <base-button
                @click="onSaveClick"
                is-primary
            >
                Save
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
    import BaseButton from '../../atoms/BaseButton'
    import BaseHeader from "../../atoms/BaseHeader";
    import BaseLabel from "../../../../../js/components/atoms/BaseLabel";
    import BaseCheckBox from "../../atoms/BaseCheckBox"
    import CardModal from '../../molecules/CardModal'
    import ParameterFields from "../../../../../js/components/molecules/fields/ParameterFields/ParameterFields";
    import Columns from "../../../../../js/components/atoms/Columns/Columns";
    import Column from "../../../../../js/components/atoms/Column/Column";
    import ValidatableTextField from "../../../../../js/components/molecules/fields/ValidatableTextField";
    import TextField from "../../../../../js/components/atoms/fields/TextField";
    import TextareaField from "../../../../../js/components/atoms/fields/TextareaField";
    import ValidatableTextareaField from "../../../../../js/components/molecules/fields/ValidatableTextareaField";

    // Validator.extend('path-regex', (value, args) => {
    //     return (value.match(/\//g) || []).length === args[0];
    // }, {});

    export default {
        name: 'Setting',
        components: {
            ValidatableTextareaField,
            TextareaField,
            TextField,
            ValidatableTextField,
            Column,
            Columns,
            ParameterFields,
            BaseLabel,
            BaseHeader,
            BaseCheckBox,
            BaseButton,
            CardModal,
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
            origin: {
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
            onCancelClick() {
                this.$emit('click:cancel')
            },
            onSaveClick() {
                this.$emit('click:save')
            },
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
    .path-regex-value {
        flex-wrap: wrap;
        padding: 10px;
    }
    .path-regex-value > div {
        display: flex;
        align-items: center;
    }
</style>