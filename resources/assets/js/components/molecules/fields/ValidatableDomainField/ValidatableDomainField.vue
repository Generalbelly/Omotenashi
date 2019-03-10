<template>
    <validation-provider
        :name="name"
        :rules="innerRules"
    >
        <domain-field
            v-bind="$attrs"
            slot-scope="{ errors, valid }"
            :message="errors"
            v-model="inputValue"
            :type="getType(errors, valid)"
        ></domain-field>
    </validation-provider>
</template>

<script>
    import { Validator, ValidationProvider } from 'vee-validate'
    import validatable from "../../../mixins/validatable";
    import DomainField from "../../../atoms/fields/DomainField";

    Validator.extend('domain', (value, args) => {
        const exceptions = args;
        if (exceptions.includes(value)) return true;
        const re = /^https?:\/\/(([A-Za-z0-9][A-Za-z0-9\-]{1,61}[A-Za-z0-9]|[A-Za-z0-9]{1,63})\.)+[A-Za-z]+$/
        return !!re.exec(value)
    }, {});

    export default {
        name: "ValidatableDomainField",
        mixins: [ validatable ],
        props: {
            value: {
                type: String,
                default: null
            },
            exceptionDomains: {
                type: Array,
                default() {
                    return [];
                }
            }
        },
        components: {
            DomainField,
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
            innerRules() {
                return `${this.rules}|domain:${this.exceptionDomains.join(',')}`
            }

        },
    }
</script>

<style scoped>

</style>