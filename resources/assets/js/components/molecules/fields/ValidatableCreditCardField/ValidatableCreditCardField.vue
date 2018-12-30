<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <credit-card-field
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            :message="errors"
            v-model="inputValue"
            :type="getType(errors, valid)"
        ></credit-card-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import CreditCardField from "../../../atoms/fields/CreditCardField";

    export default {
        name: "ValidatableCreditCardField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            CreditCardField,
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