<template>
    <button
        class="button is-success-050"
        @click="$emit('click')"
    >
        Start selecting
    </button>
</template>

<script>
    export default {
        name: "StartSelectingGoogleAnalyticsPropertyButton",
    }
</script>

<style scoped>

</style>