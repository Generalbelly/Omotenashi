<template>
    <base-field
        v-bind="$attrs"
    >
        <base-textarea
            v-model="inputValue"
            slot-scope="{placeholder, readonly, disabled, classes}"
            :placeholder="placeholder"
            :readonly="readonly"
            :disabled="disabled"
            :class="classes"
        >
        </base-textarea>
    </base-field>
</template>

<script>
    import BaseField from "../../../atoms/BaseField"
    import BaseTextarea from "../../../atoms/BaseTextarea";

    export default {
        name: "TextareaField",
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
        }
    }
</script>

<style scoped>

</style>