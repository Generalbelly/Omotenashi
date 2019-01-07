<template>
    <b-icon
        icon="trash"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "TrashIcon"
    }
</script>

<style scoped>

</style>