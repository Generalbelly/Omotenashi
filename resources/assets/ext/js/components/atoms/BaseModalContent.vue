<template>
    <div
        class="content"
        :class="contentClass"
    >
        <slot></slot>
    </div>
</template>
<script>
    export default {
        name: 'BaseModalContent',
        props: {
            contentClass: {
                type: String,
                default: '',
            },
        }
    }
</script>
<style scoped>
    .content {
        flex-direction: column !important;
    }
</style>