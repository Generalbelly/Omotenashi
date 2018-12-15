<template>
    <div>
    <validation-observer ref="observer">
        <div slot-scope="{invalid}">
            <validatable-text-field
               name="text"
              rules="required"
               v-model="text"
            ></validatable-text-field>
            <button @click="onSubmit">click</button>
        </div>
    </validation-observer>
    </div>
</template>

<script>
    import { ValidationObserver } from 'vee-validate'
    import ValidatableTextField from "../../molecules/Fields/ValidatableTextField"
    import TextField from "../../atoms/Fields/TextField/TextField";

    export default {
        name: "ProjectTemplate",
        components: {
            TextField,
            ValidatableTextField,
            ValidationObserver,
        },
        props: {
            isLoading: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                text: null,
                text1: null,
            }
        },
        methods: {
            onSubmit() {
                this.$refs.observer.validate()
                    .then(result => {
                        console.log(result);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>

</style>