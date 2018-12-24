<template>
    <button
        class="button is-text"
        @click="$emit('click')"
    >
        Cancel
    </button>
</template>

<script>
    export default {
        name: "CancelButton",
    }
</script>

<style scoped>

</style>