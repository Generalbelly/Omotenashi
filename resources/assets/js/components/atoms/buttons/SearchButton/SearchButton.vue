<template>
    <button
        class="button"
        @click="$emit('click', $event)"
    >
        Search
    </button>
</template>
<script>
    export default {
        name: 'SearchButton'
    }
</script>
