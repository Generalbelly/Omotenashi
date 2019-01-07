<template>
    <base-field
        v-bind="baseFieldProps"
    >
        <base-input
            v-bind="baseInputProps"
            v-model="inputValue"
            type="text"
        ></base-input>
    </base-field>
</template>

<script>
    import BaseField from "../../../atoms/BaseField"
    import BaseInput from "../../../atoms/BaseInput"
    import fieldable from '../../../mixins/fieldable'
    import inputable from '../../../mixins/inputable'
    import colorable from '../../../mixins/colorable'
    import sizable from '../../../mixins/sizable'

    export default {
        name: "TextField",
        mixins: [
            fieldable,
            colorable,
            sizable,
            inputable,
        ],
        components: {
            BaseInput,
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
            baseInputProps() {
                return {
                    ...this.inputableProps,
                    ...this.sizableProps,
                    ...this.colorableProps,
                    ...this.inputableProps,
                }
            }
        }
    }
</script>

<style scoped>

</style>