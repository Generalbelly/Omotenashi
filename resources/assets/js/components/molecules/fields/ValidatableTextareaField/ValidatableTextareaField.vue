<template>
    <validation-provider
        :name="name"
        :rules="rules"
    >
        <textarea-field
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            :message="errors"
            v-model="inputValue"
            :type="getType(errors, valid)"
        ></textarea-field>
    </validation-provider>
</template>

<script>
    import { ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import TextareaField from "../../../atoms/fields/TextareaField/TextareaField";

    export default {
        name: "ValidatableTextareaField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
        },
        components: {
            TextareaField,
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