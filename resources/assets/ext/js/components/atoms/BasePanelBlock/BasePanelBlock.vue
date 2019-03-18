<template>
    <div
        class="panel-block"
        @click="$emit('click', $event)"
    >
        <slot></slot>
    </div>
</template>
<script>
    export default {
        name: "BasePanelBlock",
    }
</script>

<style scoped>
</style>