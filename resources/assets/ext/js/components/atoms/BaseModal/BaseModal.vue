<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: 'BaseModal',
    }
</script>
