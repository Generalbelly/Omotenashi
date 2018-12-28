<template>
    <button
        class="button is-danger is-outlined"
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="trash"
        >
        </b-icon>
        <span>Delete</span>
    </button>
</template>

<script>
    export default {
        name: "DeleteButton",
    }
</script>

<style scoped>

</style>