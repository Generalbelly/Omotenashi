<template>
    <span
        class="has-cursor-pointer icon"
        @click="$emit('click')"
    >
        <font-awesome-icon :icon="icon"></font-awesome-icon>
    </span>
</template>

<script>
    export default {
        name: 'BaseIconButton',
        props: {
            icon: {
                type: String,
                default: '',
            },
        },
    }
</script>
