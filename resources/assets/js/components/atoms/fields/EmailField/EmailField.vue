<template>
    <b-field v-bind="$attrs">
        <b-input
            v-model="inputValue"
            type="email"
            icon="envelope"
        ></b-input>
    </b-field>
</template>

<script>
    export default {
        name: "EmailField",
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
            }
        },
    }
</script>

<style scoped>

</style>