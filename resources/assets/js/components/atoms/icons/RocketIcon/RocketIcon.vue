<template>
    <b-icon
        icon="rocket"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "RocketIcon"
    }
</script>

<style scoped>

</style>