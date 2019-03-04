<template>
    <button
        class="button is-text"
        @click="$emit('click')"
    >
        Connect a different property
    </button>
</template>

<script>
    export default {
        name: "ConnectDifferentGoogleAnalyticsPropertyButton",
    }
</script>

<style scoped>

</style>