<template>
    <label class="checkbox">
        <input
            type="checkbox"
            :value="value"
            :checked="value"
            :true-value="trueValue"
            :false-value="falseValue"
            @change="$emit('change', $event.target.checked)"
            @input="$emit('input', $event.target.checked)"
            style="display: inline-block;"
        >
        <slot></slot>
    </label>
</template>

<script>
    export default {
        name: 'BaseCheckBox',
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            trueValue: {
                type: [String, Boolean, Number],
                default: true,
            },
            falseValue: {
                type: [String, Boolean, Number],
                default: false,
            },
        },
    }
</script>