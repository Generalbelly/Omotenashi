<template>
    <div>
        <div class="parameter__labels">
            <base-label>Key</base-label>
            <base-label>Value</base-label>
        </div>
        <div
            v-for="(p, pIndex) in inputValue"
            :key="pIndex"
            class="parameter__input"
        >
            <validatable-text-field
                :value="p.key"
                @input="updateParameter(pIndex, { key: $event} )"
                rules="required"
                name="parameter key"
                class="is-marginless"
            ></validatable-text-field>
            <validatable-text-field
                :value="p.value"
                @input="updateParameter(pIndex, { value: $event })"
                rules="required"
                name="parameter value"
                class="is-marginless"
            ></validatable-text-field>
            <trash-icon
                class="has-cursor-pointer"
                @click="deleteParameter(pIndex)"
            ></trash-icon>
        </div>
        <div class="has-margin-top-1">
            <base-button
                @click="addParameter"
                is-text
            >
                Add parameter
            </base-button>
        </div>
    </div>
</template>

<script>
    import BaseButton from "../../../atoms/BaseButton";
    import BaseLabel from "../../../atoms/BaseLabel";
    import BaseIcon from "../../../atoms/BaseIcon";
    import ValidatableTextField from "../../../../../../js/components/molecules/fields/ValidatableTextField";
    import TrashIcon from "../../../../../../js/components/atoms/icons/TrashIcon";

    export default {
        name: "ParameterFields",
        components: {
            TrashIcon,
            ValidatableTextField,
            BaseIcon,
            BaseLabel,
            BaseButton,
        },
        props: {
            value: {
                type: Array,
                default() {
                    return [];
                }
            },
        },

        computed: {
            inputValue: {
                get() {
                    return this.value;
                },
                set(newValue) {
                    return this.$emit('input', newValue)
                },
            },
        },
        methods: {
            addParameter() {
                this.inputValue = [
                    ...this.inputValue,
                    {
                        key: '',
                        value: '',
                    }
                ]
            },
            updateParameter(index, value) {
                this.inputValue = [
                    ...this.inputValue.slice(0, index),
                    {
                        ...this.inputValue[index],
                        ...value,
                    },
                    ...this.inputValue.slice(index+1),
                ]
            },
            deleteParameter(index) {
                this.inputValue = [
                    ...this.inputValue.slice(0, index),
                    ...this.inputValue.slice(index+1),
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