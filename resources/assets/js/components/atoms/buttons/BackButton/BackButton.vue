<template>
    <button
        class="button"
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