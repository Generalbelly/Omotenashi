<template>
    <div class="content">
        <slot></slot>
    </div>
</template>

<script>
    import sizable from '../../mixins/sizable'

    export default {
        name: "BaseContent",
        mixins: [sizable],
    }
</script>

<style scoped>
</style>