<template>
    <b-field v-bind="$attrs">
        <b-select
            v-model="inputValue"
            :placeholder="placeholder"
        >
            <option
                v-for="(option, optionIndex) in items"
                :key="optionIndex"
                :value="option.value"
            >
                {{ option.text }}
            </option>
        </b-select>
    </b-field>
</template>

<script>
    export default {
        name: "SelectField",
        props: {
            value: {
                type: String,
                default: null
            },
            placeholder: {
                type: String,
                default: null
            },
            items: {
                type: Array,
                default() {
                    return [];
                },
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