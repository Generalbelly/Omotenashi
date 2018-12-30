<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <text-field
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            v-model="inputValue"
            :messages="errors"
            :is-success="errors.length === 0 && valid"
            :is-danger="errors.length > 0 && !valid"
        ></text-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../../../../js/components/mixins/validatable";
    import TextField from "../TextField";

    export default {
        name: "ValidatableTextField",
        mixins: [
            validatable
        ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            TextField,
            ValidationProvider,
        },
        computed: {
            inputValue: {
                get() {
                    return this.value;
                },
                set(newValue) {
                    return this.$emit('input', newValue)
                },
            },

        },
    }
</script>

<style scoped>

</style>