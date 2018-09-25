<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div
            class="modal-content has-background-white has-padding-5"
            :class="modalClass"
        >
            <div
                class="content"
                :class="contentClass"
            >
                <slot name="content"></slot>
            </div>
        </div>
        <button
            v-if="showClose"
            class="modal-close is-large is-paddingless"
            aria-label="close"
            @click="$emit('closeClick')"
        ></button>
    </div>
</template>
<script>
export default {
    props: {
        showClose: {
            type: Boolean,
            default: true,
        },
        modalContentClasses: {
            type: Array,
            default() {
                return [];
            }
        },
        contentClasses: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {};
    },
    computed: {
        modalClass() {
            return this.convertArrayToObject(this.modalContentClasses)
        },
        contentClass() {
            return this.convertArrayToObject(this.contentClasses)
        }
    }
};
</script>
<style>
    .modal {
        z-index: 10000000000 !important;
    }
</style>
<style scoped>
    .content {
        flex-direction: column !important;
    }
</style>