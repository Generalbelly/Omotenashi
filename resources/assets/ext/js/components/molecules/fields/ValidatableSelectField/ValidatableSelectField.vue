<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <select-field
            v-bind="$attrs"
            v-model="inputValue"
            slot-scope="{ errors, valid }"
            :messages="errors"
            :is-success="errors.length === 0 && valid"
            :is-danger="errors.length > 0 && !valid"
        ></select-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import SelectField from "../SelectField";

    export default {
        name: "ValidatableSelectField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            SelectField,
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