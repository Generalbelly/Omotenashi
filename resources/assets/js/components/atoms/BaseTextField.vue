<template>
    <div class="field">
        <label class="label">{{ label }}</label>
        <p class="control">
            <input
                class="input"
                :type="type"
                :placeholder="placeholder"
                :name="name"
                :id="id"
                :value="value"
                @input="$emit('input', $event.target.value)"
            >
        </p>
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
        name: "BaseTextField",
        props: {
            placeholder: {
                type: String,
                default: '',
            },
            type: {
                type: String,
                default: 'text',
            },
            value: {
                type: String,
                default: '',
            },
            label: {
                type: String,
                default: '',
            },
            id: {
                type: String,
                default: '',
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