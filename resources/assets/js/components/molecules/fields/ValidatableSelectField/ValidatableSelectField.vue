<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <select-field
            v-model="inputValue"
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            :message="errors"
            :type="getType(errors, valid)"
        ></select-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import SelectField from "../../../atoms/fields/SelectField/SelectField";

    export default {
        name: "ValidatableTextField",
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