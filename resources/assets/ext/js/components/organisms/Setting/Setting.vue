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
                rules="required"
            >
            </validatable-textarea-field>
            <div>
                Show this tutorial for a user visiting the following url.
                <text-field
                    :value="url"
                    name="url"
                    rules="required"
                    disabled
                ></text-field>
                <!--<base-check-box-->
                    <!--v-model="hasDynamicUrlPath"-->
                <!--&gt;-->
                    <!--Does a part of the url dynamically change?-->
                <!--</base-check-box>-->
                <!--<div>-->
                    <!--The url changes after the following url path.-->
                    <!--<text-field-->
                        <!--v-model="innerStaticPath"-->
                    <!--&gt;</text-field>-->
                <!--</div>-->
                <base-check-box
                    v-model="withParameters"
                >
                    with parameters
                </base-check-box>
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
    import BaseIcon from '../../atoms/BaseIcon'
    import BaseButton from '../../atoms/BaseButton'
    import CardModal from '../../molecules/CardModal'
    import BaseCheckBox from "../../atoms/BaseCheckBox"
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField";
    import TextField from "../../molecules/fields/TextField";
    import ValidatableTextareaField from "../../molecules/fields/ValidatableTextareaField";
    import BaseHeader from "../../atoms/BaseHeader";
    import BaseLabel from "../../atoms/BaseLabel";
    import ParameterFields from "../../molecules/fields/ParameterFields/ParameterFields";

    export default {
        name: 'Setting',
        components: {
            ParameterFields,
            BaseLabel,
            BaseHeader,
            ValidatableTextareaField,
            ValidatableTextField,
            TextField,
            BaseCheckBox,
            BaseButton,
            CardModal,
            BaseIcon,
        },
        props: {
            id: {
                type: String,
                default: null,
            },
            url: {
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
            static_path: {
                type: String,
                default: null,
            },
            parameters: {
                type: Array,
                default() {
                    return [];
                }
            },
        },
        data() {
            return {
                withParameters: false,
                hasDynamicUrlPath: false,
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
                    return this.parameters
                },
                set(newValue) {
                    this.$emit('update:parameters', newValue)
                }
            },
            innerStaticPath: {
                get() {
                    return this.static_path
                },
                set(newValue) {
                    this.$emit('update:static_path', newValue)
                }
            }
        },
        watch: {
            withParameters(value) {
                if (value) {
                    this.innerParameters = [
                        {
                            key: '',
                            value: '',
                        }
                    ]
                } else {
                    this.innerParameters = []
                }
            }
        },
        methods: {
            onCancelClick() {
                this.$emit('click:cancel')
            },
            onSaveClick() {
                this.$emit('click:save')
            },
        }
    }

</script>
