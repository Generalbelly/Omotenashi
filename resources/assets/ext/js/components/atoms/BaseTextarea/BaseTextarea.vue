<template>
    <textarea
        class="textarea"
        v-bind="$attrs"
        v-model="inputValue"
    >
    </textarea>
</template>

<script>
    export default {
        name: "BaseTextarea",
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