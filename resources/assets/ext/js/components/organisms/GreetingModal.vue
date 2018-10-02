<template>
    <Modal
        @closeClick="$emit('closeClick')"
        :show-close="false"
    >
        <h1>Omotenashi</h1>
        <p class="has-padding-top-4 has-margin-bottom-5 has-text-left">
            Tutorials for user onboarding is hard to build and maintain.<br />
            Omotenashi makes it easy and fun by enabling you to create them code-free.<br/><br/>
            If you have any question or feedback, please click the feedback button below and submit a feedback form.
        </p>
        <div>
            <BaseButton
                is-success
                @click="$emit('startClick')"
            >
                Let's get started
            </BaseButton>
        </div>
    </Modal>
</template>
<script>
    import Modal from '../molecules/Modal';
    import BaseButton from '../atoms/BaseButton';

    export default {
        components: {
            Modal,
            BaseButton,
        }
    }
</script>