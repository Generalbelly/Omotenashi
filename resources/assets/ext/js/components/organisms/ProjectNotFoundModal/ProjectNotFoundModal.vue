<template>
    <modal
        :contentClass="['has-padding-5']"
        :show-close="false"
    >
        <p class="has-padding-bottom-4 has-text-weight-bold">Oops! Something went wrong.</p>
        <p class="has-padding-bottom-5 has-text-left">
            We couldn't find a project with a domain matching this page's.<br>
            Please create a project first.
        </p>
        <div>
            <a
                class="button is-link"
                href="http://docker.omotenashi.today"
                target="_blank"
            >
                Go to Omotenashi
            </a>
        </div>
    </modal>
</template>
<script>
    import Modal from '../../molecules/Modal';

    export default {
        components: {
            Modal,
        }
    }
</script>