<template>
    <header class="modal-card-head has-margin-0">
        <p class="modal-card-title">
            <slot></slot>
        </p>
    </header>
</template>
<script>
    export default {
        name: 'BaseCardModalHeader',
    }
</script>
