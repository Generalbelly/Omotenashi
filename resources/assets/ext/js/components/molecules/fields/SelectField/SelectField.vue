<template>
    <base-field
        v-bind="baseFieldProps"
    >
        <base-select-input
            v-bind="baseSelectInputProps"
            v-model="inputValue"
        ></base-select-input>
    </base-field>
</template>

<script>
    import BaseField from "../../../atoms/BaseField"
    import BaseSelectInput from '../../../atoms/BaseSelectInput'
    import fieldable from '../../../mixins/fieldable'
    import selectInputable from '../../../mixins/selectInputable'
    import colorable from '../../../mixins/colorable'
    import sizable from '../../../mixins/sizable'

    export default {
        name: "SelectField",
        mixins: [
            fieldable,
            colorable,
            sizable,
            selectInputable,
        ],
        components: {
            BaseSelectInput,
            BaseField
        },
        props: {
            value: {
                type: String,
                default: null
            },
        },
        computed: {
            inputValue: {
                get() {
                    return this.value
                },
                set(newValue) {
                    this.$emit('input', newValue)
                }
            },
            baseFieldProps() {
                return {
                    ...this.fieldableProps,
                    ...this.colorableProps,
                    ...this.sizableProps,
                }
            },
            baseSelectInputProps() {
                return {
                    ...this.selectInputableProps,
                    ...this.sizableProps,
                    ...this.colorableProps,
                }
            }
        }
    }
</script>

<style scoped>

</style>