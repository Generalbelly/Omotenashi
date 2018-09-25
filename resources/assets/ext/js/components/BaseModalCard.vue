<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <slot></slot>
        </div>
    </div>
</template>
<script>
    export default {
        props: {},
        data() {
            return {};
        }
    }
</script>
