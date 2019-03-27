<template>
    <div>
        <base-label>
            Tutorial distribution (if more than one created
            <question-circle-icon
                class="has-cursor-pointer"
                size="is-small"
                @click="showDistributionDetail = !showDistributionDetail"
            ></question-circle-icon>
        </base-label>
        <column class="has-margin-bottom-5">
            <template v-for="option in pickingMethodOptions">
                <radio-field
                    v-model="pickingMethod"
                    :native-value="option.value"
                >
                    {{ option.text }}
                </radio-field>
            </template>
            <message :active="showDistributionDetail" class="has-margin-y-3">
                For one URL you can create as many tutorials as you like to compare the effectiveness of different styles between users. <br>
                This option determines the distribution pattern towards your users.
            </message>
        </column>
        <base-label>
            Hide after viewing once
        </base-label>
        <column>
            <template v-for="option in booleanOptions">
                <radio-field
                    v-model="onlyOnce"
                    :native-value="option.value"
                    :key="option.value"
                >
                    {{ option.text }}
                </radio-field>
            </template>
        </column>
        <fade-transition-group v-if="onlyOnce">
            <base-label key="label">
                For how long?
            </base-label>
            <column key="column">
                <grouped-field key="field">
                    <validatable-select-field
                        key="onlyOnceDurationOptions"
                        :items="onlyOnceDurationOptions"
                        v-model="onlyOnceDuration"
                        name="Duration"
                        rules="required"
                    ></validatable-select-field>
                    <validatable-text-field
                        key="onlyOnceCustomDuration"
                        v-if="onlyOnceDuration !== 'forever'"
                        name="Custom duration"
                        :rules="{'required': onlyOnceDuration !== 'forever', 'numeric': true}"
                        :value="value.only_once_duration === 'forever' ? '' : value.only_once_duration"
                        @input="updateOnlyOnceDuration"
                    >
                    </validatable-text-field>
                    <div
                        v-show="onlyOnceDuration !== 'forever'"
                        class="label"
                        style="margin-top: 5px; margin-left: 5px;"
                    >
                        Days
                    </div>
                </grouped-field>
            </column>
        </fade-transition-group>
    </div>
</template>

<script>
    import Column from "../../../atoms/Column/Column"
    import FadeTransitionGroup from "../../../atoms/transitions/FadeTransitionGroup/FadeTransitionGroup"
    import GroupedField from "../../../layouts/GroupedField/GroupedField"
    import RadioField from "../../../atoms/fields/RadioField"
    import ValidatableSelectField from "../../../molecules/fields/ValidatableSelectField"
    import ValidatableTextField from "../../../molecules/fields/ValidatableTextField"
    import QuestionCircleIcon from "../../../atoms/icons/QuestionCircleIcon/QuestionCircleIcon";
    import Message from "../../../atoms/Message/Message";
    import BaseLabel from "../../../../../ext/js/components/atoms/BaseLabel/BaseLabel";

    export default {
        name: 'tutorial-setting-fields',
        components: {
            BaseLabel,
            Message,
            QuestionCircleIcon,
            Column,
            FadeTransitionGroup,
            GroupedField,
            RadioField,
            ValidatableSelectField,
            ValidatableTextField
        },
        props: {
            value: {
                type: Object,
                default() {
                    return {}
                }
            },
        },
        data() {
            return {
                onlyOnceDuration: null,
                showDistributionDetail: false,
                showOnlyFirstTimeDetail: false,
            }
        },
        computed: {
            pickingMethod: {
                get() {
                    return this.value.distribution_ratio
                },
                set(newValue) {
                    this.updateTutorialSettings('distribution_ratio', newValue)
                }
            },
            onlyOnce: {
                get() {
                    if (this.value) {
                        this.onlyOnceDuration = this.value.only_once_duration === 'forever' ? 'forever' : 'custom'
                    }
                    return this.value.only_once
                },
                set(newValue) {
                    this.updateTutorialSettings('only_once', newValue)
                }
            },
            pickingMethodOptions() {
                return [
                    {
                        text: 'Random',
                        value: 'random',
                    },
                    {
                        text: 'Even',
                        value: 'even',
                    }
                ]
            },
            booleanOptions() {
                return [
                    {
                        text: 'Yes',
                        value: true,
                    },
                    {
                        text: 'No',
                        value: false,
                    }
                ]
            },
            onlyOnceDurationOptions() {
                return [
                    {
                        text: 'Forever',
                        value: 'forever',
                    },
                    {
                        text: 'Custom',
                        value: 'custom',
                    }
                ]
            },
        },
        methods: {
            updateTutorialSettings(key, value) {
                this.$emit('input', {
                    ...this.value,
                    [key]: value,
                })
            },
            updateOnlyOnceDuration(value) {
                this.updateTutorialSettings('only_once_duration', value)
            }
        }
    }
</script>
