<template>
    <button
        class="button"
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="plug"
        >
        </b-icon>
        <span>Revoke the connected account</span>
    </button>
</template>

<script>
    export default {
        name: "RevokeGoogleAnalyticsButton",
    }
</script>

<style scoped>

</style>