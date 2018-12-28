<template>
    <Modal
        :contentClass="['has-padding-5']"
        :show-close="false"
    >
        <h1 class="has-padding-bottom-4">Oops, sorry we couldn't find your project.</h1>
        <p class="has-padding-bottom-4 has-text-left">
            Seems like you haven't created a project with a domain matching this page's.
            Please create a project first.
        </p>
        <div>
            <a
                class="button is-link"
                href="http://docker.omotenashi.today"
            >
                Go to Omotenashi
            </a>
        </div>
    </Modal>
</template>
<script>
    import Modal from '../../molecules/Modal';
    import BaseButton from '../../atoms/BaseButton';

    export default {
        components: {
            Modal,
            BaseButton,
        }
    }
</script>