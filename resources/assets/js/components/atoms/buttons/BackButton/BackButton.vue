<template>
    <button
        class="button is-neutral-100"
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