<template>
    <modal
        :contentClass="['has-padding-5']"
        :show-close="false"
    >
        <p class="has-padding-bottom-4 has-text-weight-bold">Oops! Something went wrong.</p>
        <p class="has-padding-bottom-5 has-text-left">
            We couldn't find a project having a whitelisted domain matching this page's.<br>
            Please create a project first or add this domain as a whitelisted one to your project.
        </p>
        <div class="level">
            <base-button
                :href="url"
                target="_blank"
                class="level-left"
            >
                Go to Omotenashi
            </base-button>
            <base-button
                class="is-text level-right"
                :class="{'is-loading': isRequesting}"
                @click="$emit('click:retry')"
            >
                Try loading again?
            </base-button>
        </div>
    </modal>
</template>
<script>
    import Modal from '../../molecules/Modal'
    import BaseButton from "../../atoms/BaseButton";

    export default {
        name: 'ProjectNotFoundModal',
        components: {
            BaseButton,
            Modal,
        },
        props: {
            isRequesting: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                url: process.env.APP_URL,
            }
        }
    }
</script>