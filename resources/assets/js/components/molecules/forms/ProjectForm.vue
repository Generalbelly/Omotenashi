<template>
    <div>
        <div class="has-margin-bottom-5">
            <validatable-text-field
                label="Name"
                name="name"
                rules="required"
                :value="name"
                @input="$emit('update:name', $event)"
            ></validatable-text-field>
            <validatable-text-field
                label="Domain"
                name="domain"
                rules="required|domain"
                :value="domain"
                @input="$emit('update:domain', $event)"
            >
            </validatable-text-field>
        </div>
    </div>
</template>

<script>
    import { Validator } from 'vee-validate'
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField"
    import DeleteButton from "../../atoms/buttons/DeleteButton/DeleteButton";

    Validator.extend('domain', (value, args) => {
        const re = /([A-Za-z0-9][A-Za-z0-9\-]{1,61}[A-Za-z0-9]\.)+[A-Za-z]+/
        return !!re.exec(value)
    });

    export default {
        name: "ProjectForm",
        components: {
            DeleteButton,
            ValidatableTextField,
        },
        props: {
            name: {
                type: String,
                default: null,
            },
            domain: {
                type: String,
                default: null,
            },
        },
    }
</script>

<style scoped>

</style>