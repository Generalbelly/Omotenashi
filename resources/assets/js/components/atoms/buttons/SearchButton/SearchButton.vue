<template>
    <button
        class="button"
        @click="$emit('click:search')"
    >
        Search
    </button>
</template>
<script>
    export default {
        name: 'SearchButton'
    }
</script>
