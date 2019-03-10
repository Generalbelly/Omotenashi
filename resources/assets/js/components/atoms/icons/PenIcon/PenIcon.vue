<template>
    <b-icon
        icon="pen"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "PenIcon"
    }
</script>

<style scoped>

</style>