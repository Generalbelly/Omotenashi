<template>
    <button
        class="button is-text"
        @click="$emit('click')"
    >
        Back
    </button>
</template>

<script>
    export default {
        name: "BackButton",
    }
</script>

<style scoped>

</style>