<template>
    <BaseModal
        @closeClick="$emit('closeClick')"
        :modal-content-class="modalContentClass"
        :content-class="contentClass"
    >
        <h1>Omotenashi</h1>
        <p class="has-padding-top-4 has-margin-bottom-5 has-text-left">
            Tutorials for user onboarding is hard to build and maintain.<br />
            Omotenashi makes it easy and fun by enabling you to create them code-free.<br/><br/>
            If you have any question or feedback, please click the feedback button below and submit a feedback form.
        </p>
        <div>
            <button
                    class="button is-success"
                    @click="$emit('startClick')"
            >
                Let's get started
            </button>
        </div>
    </BaseModal>
</template>
<script>
import BaseModal from '../BaseModal';

export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            modalContentClass: ['has-background-white'],
            contentClass: ['has-padding-5'],
        };
    },
    components: {
        BaseModal
    }
}
</script>