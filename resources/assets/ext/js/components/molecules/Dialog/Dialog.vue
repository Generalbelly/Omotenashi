<template>
    <Modal>
        <div>
            <slot></slot>
        </div>
        <div>
            <BaseButton @click="onConfirmClick">OK</BaseButton>
            <BaseButton @click="onCancelClick">Cancel</BaseButton>
        </div>
    </Modal>
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
            return {
                subscribers: [],
                handlers: {
                    confirm: [],
                    cancel: [],
                },
            }
        },
        methods: {
            subscribe(eventName, cb) {
                this.handlers[eventName] = [
                    ...this.handlers[eventName],
                    cb,
                ]
            },
            unsubscribe(eventName, cb) {
                this.handlers[eventName] = this.handlers[eventName].filter(item => item !== cb)
            },
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
