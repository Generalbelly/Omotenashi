<template>
    <button
        class="button is-primary"
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="plus"
        >
        </b-icon>
        <span>Add</span>
    </button>
</template>

<script>
    export default {
        name: "AddButton",
    }
</script>

<style scoped>

</style>