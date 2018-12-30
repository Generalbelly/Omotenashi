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
            <validatable-domain-field
                label="Domain"
                name="domain"
                rules="required"
                :value="domain"
                @input="$emit('update:domain', $event)"
            >
            </validatable-domain-field>
            <div class="level">
                <div class="level-right">
                    <add-button
                        class="level-item"
                    ></add-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ValidatableTextField from "../../molecules/fields/ValidatableTextField"
    import ValidatableDomainField from "../fields/ValidatableDomainField";
    import DeleteButton from "../../atoms/buttons/DeleteButton/DeleteButton";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";

    export default {
        name: "ProjectForm",
        components: {
            AddButton,
            ValidatableDomainField,
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