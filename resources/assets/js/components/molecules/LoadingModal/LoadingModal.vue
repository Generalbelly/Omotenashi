<template>
    <BaseModal class="loading-modal">
        <BaseProgressCircular
            is-medium
        ></BaseProgressCircular>
    </BaseModal>
</template>

<script>
    import BaseModal from "../../../../ext/js/components/atoms/BaseModal";
    import BaseProgressCircular from "../../../../ext/js/components/atoms/BaseProgressCircular";
    export default {
        name: 'LoadingModal',
        components: {
            BaseModal,
            BaseProgressCircular,
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
        z-index: 10000000000 !important;
    }
</style>
