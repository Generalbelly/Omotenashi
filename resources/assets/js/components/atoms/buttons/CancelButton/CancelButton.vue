<template>
    <button
        class="button is-outlined"
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