<template>
    <b-radio
        v-model="inputValue"
        v-bind="$attrs"
    >
        <slot></slot>
    </b-radio>
</template>

<script>
    export default {
        name: "RadioField",
        props: {
            value: {
                type: String,
                default: null,
            }
        },
        computed: {
            inputValue: {
                get() {
                    return this.value
                },
                set(newValue) {
                    this.$emit('input', newValue)
                }
            }
        }
    }
</script>

<style scoped>

</style>