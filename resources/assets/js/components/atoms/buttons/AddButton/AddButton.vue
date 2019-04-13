<template>
    <button
        class="button is-primary"
        @click="$emit('click')"
    >
        <plus-icon></plus-icon>
        <span>
            <slot>Add</slot>
        </span>
    </button>
</template>

<script>
    import PlusIcon from "../../icons/PlusIcon";
    export default {
        name: "AddButton",
        components: {PlusIcon},
    }
</script>

<style scoped>

</style>