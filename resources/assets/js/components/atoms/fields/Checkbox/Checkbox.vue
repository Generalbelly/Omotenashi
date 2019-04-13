<template>
    <div class="field">
        <b-checkbox
            v-model="inputValue"
            v-bind="$attrs"
        >
            <slot></slot>
        </b-checkbox>
    </div>
</template>

<script>
    export default {
        name: "Checkbox",
        props: {
            value: {
                type: [String, Boolean],
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
        }
    }
</script>

<style scoped>

</style>