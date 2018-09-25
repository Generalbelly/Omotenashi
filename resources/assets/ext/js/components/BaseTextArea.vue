<template>
    <div class="field">
        <label class="label">{{ label }}</label>
        <div class="control">
            <textarea
                :value="value"
                @input="$emit('input', $event.target.value)"
                class="textarea"
                :placeholder="placeholder"
            >
            </textarea>
        </div>
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
            }
        }
    }
</script>

<style scoped>
    .label {
        text-align: left;
    }
</style>