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
        <slot name="actions">
            <div class="buttons">
                <save-button
                    @click="$emit('click:save')"
                ></save-button>
                <back-button
                    @click="$emit('click:back')"
                >
                </back-button>
            </div>
        </slot>
    </div>
</template>

<script>
    import { Validator } from 'vee-validate'
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField"
    import SaveButton from "../../atoms/buttons/SaveButton/SaveButton";
    import CancelButton from "../../atoms/buttons/CancelButton/CancelButton";
    import BackButton from "../../atoms/buttons/BackButton/BackButton";

    Validator.extend('domain', (value, args) => {
        const re = /^(([a-zA-Z]{1})|([a-zA-Z]{1}[a-zA-Z]{1})|([a-zA-Z]{1}[0-9]{1})|([0-9]{1}[a-zA-Z]{1})|([a-zA-Z0-9][a-zA-Z0-9-_]{1,61}[a-zA-Z0-9]))\.([a-zA-Z]{2,6}|[a-zA-Z0-9-]{2,30}\.[a-zA-Z]{2,3})$/
        return !!re.exec(value)
    });

    export default {
        name: "ProjectForm",
        components: {
            BackButton,
            ValidatableTextField,
            SaveButton,
            CancelButton,
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