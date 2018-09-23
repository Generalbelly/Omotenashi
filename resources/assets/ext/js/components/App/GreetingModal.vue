<template>
    <BaseModal
        @closeClick="$emit('closeClick')"
        :modal-content-classes="modalContentClasses"
        :content-classes="contentClasses"
        :show-close="false"
    >
        <template slot="content">
            <h1>Omotenashi</h1>
            <p class="has-padding-top-4 has-margin-bottom-5 has-text-left">
                Tutorials for user onboarding is hard to build and maintain.<br />
                Omotenashi makes it easy and fun by enabling you to create them code-free.<br/><br/>
                If you have any question or feedback, please click the feedback button below and submit a feedback form.
            </p>
            <div>
                <BaseButton
                    :classes="['is-success']"
                    @click="$emit('startClick')"
                >
                    Let's get started
                </BaseButton>
            </div>
        </template>
    </BaseModal>
</template>
<script>
import BaseModal from '../BaseModal';
import BaseButton from '../BaseButton';

export default {
    data() {
        return {
            modalContentClasses: ['has-background-white', 'has-padding-5'],
            contentClasses: [''],
        };
    },
    components: {
        BaseButton,
        BaseModal,
    }
}
</script>