<template>
    <button
        class="button"
        @click="$emit('click')"
    >
        <span>Confirm</span>
    </button>
</template>

<script>
    export default {
        name: "ConfirmButton",
    }
</script>

<style scoped>

</style>