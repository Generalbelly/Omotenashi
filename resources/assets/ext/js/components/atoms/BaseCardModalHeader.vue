<template>
    <header class="modal-card-head">
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
