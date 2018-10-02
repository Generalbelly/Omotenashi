<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div
            class="modal-content has-background-white has-padding-5"
            :class="modalClass"
        >
            <slot></slot>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'BaseModal',
        props: {
            modalClass: {
                type: String,
                default: '',
            }
        }
    }
</script>
