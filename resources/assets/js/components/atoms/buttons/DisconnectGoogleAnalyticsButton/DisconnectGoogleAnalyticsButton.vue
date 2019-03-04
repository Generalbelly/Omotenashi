<template>
    <button
        class="button is-text"
        @click="$emit('click')"
    >
        Disconnect
    </button>
</template>

<script>
    export default {
        name: "DisconnectGoogleAnalyticsButton",
    }
</script>

<style scoped>

</style>