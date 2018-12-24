<template>
    <b-field v-bind="$attrs">
        <b-input v-model="inputValue"></b-input>
        <b-autocomplete
            v-model="inputValue"
            :data="items"
        >
            <template
                v-for="slot in Object.keys($scopedSlots)"
                :slot="slot"
                slot-scope="scope"
            >
                <slot
                        :name="slot"
                        v-bind="scope"
                >
                </slot>
            </template>
        </b-autocomplete>
    </b-field>
</template>

<script>
    export default {
        name: "AutocompleteField",
        props: {
            value: {
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