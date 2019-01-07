<template>
    <b-icon
        icon="question-circle"
        @click.native="$emit('click')"
        pack="far"
        v-bind="$attrs"
    >
    </b-icon>
</template>

<script>
    export default {
        name: "QuestionCircleIcon"
    }
</script>

<style scoped>

</style>