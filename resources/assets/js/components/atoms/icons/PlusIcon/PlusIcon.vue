<template>
    <b-icon
        icon="plus"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "PlusIcon"
    }
</script>

<style scoped>

</style>