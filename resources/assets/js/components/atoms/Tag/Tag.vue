<template>
    <span
        class="tag"
    >
        <slot></slot>
    </span>
</template>

<script>
    import sizable from '../../../../ext/js/components/mixins/sizable'
    export default {
        name: "Tag",
        mixins: [sizable],
    }
</script>

<style scoped>

</style>