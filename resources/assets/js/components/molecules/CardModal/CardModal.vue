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
    import BaseButton from '../../../../ext/js/components/atoms/BaseButton'
    import BaseTextField from '../../../../ext/js/components/atoms/BaseTextField'
    import BaseTextArea from '../../../../ext/js/components/atoms/BaseTextArea'
    import BaseCardModal from '../../../../ext/js/components/atoms/BaseCardModal'
    import BaseCardModalHeader from '../../../../ext/js/components/atoms/BaseCardModalHeader'
    import BaseCardModalBody from '../../../../ext/js/components/atoms/BaseCardModalBody'
    import BaseCardModalFooter from '../../../../ext/js/components/atoms/BaseCardModalFooter'

    export default {
        components: {
            BaseButton,
            BaseTextField,
            BaseTextArea,
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
