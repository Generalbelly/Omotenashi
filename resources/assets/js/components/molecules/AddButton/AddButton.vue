<template>
    <base-button
        is-primary
        @click="$emit('click')"
    >
        <b-icon
            pack="fas"
            icon="plus"
        >
        </b-icon>
        <span>Add</span>
    </base-button>
</template>

<script>
    import BaseButton from "../../../../ext/js/components/atoms/BaseButton/BaseButton";
    export default {
        name: "AddButton",
        components: {
            BaseButton
        }
    }
</script>

<style scoped>

</style>