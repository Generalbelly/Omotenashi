<template>
    <div class="field is-horizontal">
        <div class="field-label">
            <label class="label">{{ label }}</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        :type="type"
                        :placeholder="placeholder"
                        :name="name"
                        :id="id"
                        :value="value"
                        :readonly="readonly"
                        :disabled="disabled"
                        @input="$emit('input', $event.target.value)"
                    >
                </div>
                <p
                    v-for="errorMessage in errorMessages"
                    :key="errorMessage"
                    class="help is-danger"
                >
                    {{ errorMessage }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BaseHorizontalTextField",
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
                default: null,
            },
            name: {
                type: String,
                default: '',
            },
            readonly: {
                type: Boolean,
                default: false,
            },
            disabled: {
                type: Boolean,
                default: false,
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