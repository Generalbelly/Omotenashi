<template>
    <button
        class="button is-primary"
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="save"
        >
        </b-icon>
        <span>Save</span>
    </button>
</template>

<script>
    export default {
        name: "SaveButton",
    }
</script>

<style scoped>

</style>