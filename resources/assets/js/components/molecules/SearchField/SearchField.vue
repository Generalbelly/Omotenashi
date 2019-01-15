<template>
    <b-field v-bind="$props">
        <b-input
            placeholder="Search..."
            type="search"
            icon-pack="fas"
            icon="search"
            @input="$emit('input', $event)"
        >
        </b-input>
        <p class="control">
            <button
                class="button is-secondary"
                @click="$emit('click:search')"
            >
                Search
            </button>
        </p>
    </b-field>
</template>

<script>
    export default {
        name: "SearchField"
    }
</script>

<style scoped>

</style>