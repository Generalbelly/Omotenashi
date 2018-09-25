<template>
    <label class="checkbox">
        <input
            type="checkbox"
            :value="value"
            :checked="value"
            :true-value="true"
            :false-value="false"
            @change="$emit('change', $event.target.checked)"
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
        },
    }
</script>
