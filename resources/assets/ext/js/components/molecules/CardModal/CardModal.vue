<template>
    <BaseCardModal class="modal">
        <BaseCardModalHeader>
            <slot name="header"></slot>
        </BaseCardModalHeader>
        <BaseCardModalBody>
            <slot name="body"></slot>
        </BaseCardModalBody>
        <BaseCardModalFooter>
            <slot name="footer"></slot>
        </BaseCardModalFooter>
    </BaseCardModal>
</template>

<script>
    import BaseCardModal from '../../atoms/BaseCardModal'
    import BaseCardModalHeader from '../../atoms/BaseCardModalHeader'
    import BaseCardModalBody from '../../atoms/BaseCardModalBody'
    import BaseCardModalFooter from '../../atoms/BaseCardModalFooter'

    export default {
        components: {
            BaseCardModal,
            BaseCardModalHeader,
            BaseCardModalBody,
            BaseCardModalFooter,
        },
        name: 'CardModal',
    }
</script>

<style scoped>
    .modal {
        z-index: 10000000000 !important;
    }
</style>
