<template>
    <base-field
        v-bind="$attrs"
    >
        <base-input
            v-model="inputValue"
            type="text"
            slot-scope="{placeholder, readonly, disabled, classes}"
            :placeholder="placeholder"
            :readonly="readonly"
            :disabled="disabled"
            :class="classes"
        ></base-input>
    </base-field>
</template>

<script>
    import BaseField from "../../../atoms/BaseField"
    import BaseInput from "../../../atoms/BaseInput"

    export default {
        name: "TextField",
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
        }
    }
</script>

<style scoped>

</style>