<template>
    <button
        class="button is-secondary"
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="plug"
        >
        </b-icon>
        <span>Connect Google Analytics</span>
    </button>
</template>

<script>
    export default {
        name: "ConnectGoogleAnalyticsButton",
    }
</script>

<style scoped>

</style>