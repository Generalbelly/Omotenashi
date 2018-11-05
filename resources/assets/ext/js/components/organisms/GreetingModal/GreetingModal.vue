<template>
    <Modal
        @closeClick="$emit('closeClick')"
        :contentClass="['has-padding-5']"
        :show-close="false"
    >
        <h1 class="has-padding-bottom-4">Welcome to Omotenashi</h1>
        <p class="has-padding-bottom-4 has-text-left">
            Tutorials for user onboarding can be hard to build and maintain.<br/>
            Our goal is to make it easy and fun by enabling you to create code-free.<br/><br/>
        </p>
        <div>
            <BaseButton
                is-success
                @click="$emit('startClick')"
            >
                Let's get started!
            </BaseButton>
        </div>
    </Modal>
</template>
<script>
    import Modal from '../../../../../js/components/molecules/Modal';
    import BaseButton from '../../../../../js/components/atoms/BaseButton';

    export default {
        components: {
            Modal,
            BaseButton,
        }
    }
</script>