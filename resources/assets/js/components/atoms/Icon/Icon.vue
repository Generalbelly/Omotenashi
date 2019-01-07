<template>
    <b-icon
        pack="far"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "Icon",
    }
</script>

<style scoped>

</style>