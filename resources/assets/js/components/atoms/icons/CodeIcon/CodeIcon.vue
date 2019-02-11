<template>
    <b-icon
        icon="code"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "CodeIcon"
    }
</script>

<style scoped>

</style>