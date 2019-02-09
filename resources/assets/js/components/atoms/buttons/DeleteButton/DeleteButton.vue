<template>
    <button
        class="button"
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