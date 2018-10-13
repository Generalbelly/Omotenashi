<template>
    <span
        class="icon"
        @click="$emit('click')"
    >
        <font-awesome-icon :icon="icon"></font-awesome-icon>
    </span>
</template>

<script>
    export default {
        name: 'BaseIcon',
        props: {
            icon: {
                type: String,
                default: null,
            },
        },
    }
</script>