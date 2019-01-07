<template>
    <b-icon
        icon="frown"
        pack="far"
        v-bind="$attrs"
        @click.native="$emit('click')"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "FrownIcon"
    }
</script>

<style scoped>

</style>