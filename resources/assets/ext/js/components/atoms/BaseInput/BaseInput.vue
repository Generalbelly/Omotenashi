<template>
    <input
        class="input"
        v-bind="$attrs"
        v-model="inputValue"
    >
</template>

<script>
    export default {
        name: "BaseInput",
        props: {
            value: {
                type: String,
                default: null,
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