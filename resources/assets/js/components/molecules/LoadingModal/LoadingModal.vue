<template>
    <BaseModal class="modal">
        <div class="loading-modal is-loading"></div>
    </BaseModal>
</template>

<script>
    import BaseModal from "../../atoms/BaseModal";
    export default {
        name: 'LoadingModal',
        components: {
            BaseModal
        },
    };
</script>

<style scoped>
    .loading-modal {
        display: flex;
        align-self: center;
        justify-self: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .modal {
        z-index: 10000000000 !important;
    }
</style>
