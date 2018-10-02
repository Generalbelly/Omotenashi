<template>
    <BaseModal>
        <slot>
            <BaseModalContent
                    :content-class="contentClass"
                    :modal-class="modalClass"
            >
            </BaseModalContent>
        </slot>
        <button
            class="modal-close is-large is-paddingless"
            aria-label="close"
            @click="$emit('closeClick')"
        ></button>
    </BaseModal>
</template>
<script>
    import BaseModalContent from "../atoms/BaseModalContent";
    import BaseModal from "../atoms/BaseModal";

    export default {
        props: {
            showClose: {
                type: Boolean,
                default: true,
            },
            modalClass: {
                type: String,
                default: '',
            },
            contentClass: {
                type: String,
                default: '',
            },
        },
        data() {
            return {};
        },
        components: {
            BaseModal,
            BaseModalContent,
        }
    };
</script>
<style>
    .modal {
        z-index: 10000000000 !important;
    }
</style>
