<template>
    <b-icon
        icon="external-link-alt"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "ExternalLinkIcon"
    }
</script>

<style scoped>

</style>