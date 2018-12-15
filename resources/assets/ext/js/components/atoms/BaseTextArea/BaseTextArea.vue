<template>
    <div class="field">
        <label class="label">{{ label }}</label>
        <div class="control">
            <textarea
                :id="id"
                :name="name"
                :value="value"
                @input="$emit('input', $event.target.value)"
                class="textarea"
                :placeholder="placeholder"
            >
            </textarea>
        </div>
        <p
            v-for="errorMessage in errorMessages"
            :key="errorMessage"
            class="help is-danger"
        >
            {{ errorMessage }}
        </p>
    </div>
</template>

<script>
    export default {
        name: "BaseTextArea",
        props: {
            placeholder: {
                type: String,
                default: '',
            },
            type: {
                type: String,
                default: 'text'
            },
            value: {
                type: String,
                default: ''
            },
            label: {
                type: String,
                default: '',
            },
            id: {
                type: String,
                default: null,
            },
            name: {
                type: String,
                default: '',
            },
            errorMessages: {
                type: Array,
                default() {
                    return [];
                }
            }
        }
    }
</script>

<style scoped>
    .label {
        text-align: left;
    }
</style>