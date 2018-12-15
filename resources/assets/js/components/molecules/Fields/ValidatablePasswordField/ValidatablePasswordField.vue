<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <password-field
            slot-scope="{ errors, valid }"
            :message="errors"
            v-model="inputValue"
            :type="getType(errors, valid)"
        ></password-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import PasswordField from "../../../atoms/Fields/PasswordField/PasswordField";

    export default {
        name: "ValidatablePasswordField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            PasswordField,
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
        watch: {
            inputValue(value) {
                this.$emit('input', value)
            }
        }
    }
</script>

<style scoped>

</style>