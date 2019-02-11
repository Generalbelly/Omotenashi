<template>
    <modal>
        <div>
            <slot></slot>
        </div>
        <div>
            <base-button @click="onConfirmClick">Confirm</base-button>
            <base-button @click="onCancelClick">Cancel</base-button>
        </div>
    </modal>
</template>

<script>
    import BaseButton from "../../atoms/BaseButton";
    import Modal from "../Modal";

    export default {
        components: {
            BaseButton,
            Modal,
        },
        data() {
            return {}
        },
        methods: {
            onConfirmClick() {
                this.$emit('confirm')
                this.handlers.confirm.forEach(cb => cb())
            },
            onCancelClick() {
                this.$emit('cancel')
                this.handlers.cancel.forEach(cb => cb())
            }
        }
    };
</script>
