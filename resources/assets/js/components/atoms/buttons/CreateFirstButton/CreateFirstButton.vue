<template>
    <button
        class="button is-accent-500"
        @click="$emit('click')"
    >
        <rocket-icon></rocket-icon>
        <span><slot>Create your first item</slot></span>
    </button>
</template>

<script>
    import RocketIcon from "../../icons/RocketIcon";
    export default {
        name: "CreateFirstButton",
        components: {
            RocketIcon
        },
    }
</script>

<style scoped>

</style>