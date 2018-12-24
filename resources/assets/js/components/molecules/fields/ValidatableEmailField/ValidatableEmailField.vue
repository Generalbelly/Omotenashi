<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <email-field
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            :message="errors"
            v-model="inputValue"
            :type="getType(errors, valid)"
        ></email-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import EmailField from "../../../atoms/fields/EmailField/EmailField";

    export default {
        name: "ValidatableEmailField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            EmailField,
            ValidationProvider,
        },
        computed: {
            inputValue: {
                get() {
                    return this.value;
                },
                set(newValue) {
                    return this.$emit('input', newValue);
                },
            }
        },
    }
</script>

<style scoped>

</style>