<template>
    <base-modal class="modal">
        <base-modal-content :class="contentClasses">
            <slot></slot>
        </base-modal-content>
        <button
            v-if="showClose"
            class="modal-close is-large is-paddingless"
            aria-label="close"
            @click="$emit('closeClick')"
        ></button>
    </base-modal>
</template>

<script>
    import BaseModalContent from "../../atoms/BaseModalContent";
    import BaseModal from "../../atoms/BaseModal";

    export default {
        props: {
            showClose: {
                type: Boolean,
                default: true,
            },
            contentClass: {
                type: Array,
                default() {
                    return [];
                },
            },
        },
        data() {
            return {};
        },
        computed: {
            contentClasses() {
                return [
                    ...this.contentClass,
                    'modal__content',
                ];
            },
        },
        components: {
            BaseModal,
            BaseModalContent,
        },
    };
</script>
<style scoped>
    .modal {
        z-index: 10000000000 !important;
    }
    .modal__content {
        flex-direction: column !important;
        background: #fff;
        padding: 20px;
    }
</style>
