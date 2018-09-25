<template>
    <div class="field">
        <label class="label">{{ label }}</label>
        <p class="control">
            <input
                class="input"
                :type="type"
                :placeholder="placeholder"
                :value="value"
                @input="$emit('input', $event.target.value)"
            >
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
        }
    }
</script>

<style scoped>
    .label {
        text-align: left;
    }
</style>