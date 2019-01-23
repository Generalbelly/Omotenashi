<template>
    <button
        class="button is-text"
        @click="$emit('click')"
    >
        Delete
    </button>
</template>

<script>
    export default {
        name: "DeleteButton",
    }
</script>

<style scoped>

</style>