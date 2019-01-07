<template>
    <base-field
        v-bind="baseFieldProps"
    >
        <base-textarea
            v-bind="baseTextareaProps"
            v-model="inputValue"
        ></base-textarea>
    </base-field>
</template>

<script>
    import BaseField from "../../../atoms/BaseField"
    import BaseTextarea from "../../../atoms/BaseTextarea"
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
            BaseTextarea,
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
            baseTextareaProps() {
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