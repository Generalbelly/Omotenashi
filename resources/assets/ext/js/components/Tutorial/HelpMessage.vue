<template>
    <BaseMessage
        class="message-container"
        @closeClick="$emit('closeClick')"
        :is-fixed-top-right="isFixedTopRight"
        :is-fixed-top-left="isFixedTopLeft"
        :is-fixed-bottom-right="isFixedBottomRight"
        :is-fixed-bottom-left="isFixedBottomLeft"
        :is-info="isInfo"
        :is-warning="isWarning"
    >
        <BaseMessageHeader>
            <slot name="header"></slot>
        </BaseMessageHeader>
        <BaseMessageBody>
            <slot name="body"></slot>
            <p v-if="hasDontShowMeOption" class="has-margin-top-3">
                <BaseCheckBox
                    :value="dontShowMe"
                    @change="onDontShowMeChenge"
                >
                    Don't show me this message again.
                </BaseCheckBox>
            </p>
        </BaseMessageBody>
    </BaseMessage>
</template>

<script>
    import BaseMessage from '../BaseMessage'
    import BaseMessageHeader from '../BaseMessageHeader'
    import BaseMessageBody from '../BaseMessageBody'
    import BaseCheckBox from "../BaseCheckBox";

    export default {
        name: "HelpMessage",
        props: {
            hasDontShowMeOption: {
                type: Boolean,
                default: false,
            },
            dontShowMe: {
                type: Boolean,
                default: false,
            },
            isFixedTopRight: {
                type: Boolean,
                default: true,
            },
            isFixedTopLeft: {
                type: Boolean,
                default: false,
            },
            isFixedBottomRight: {
                type: Boolean,
                default: false,
            },
            isFixedBottomLeft: {
                type: Boolean,
                default: false,
            },
        },
        components: {
            BaseCheckBox,
            BaseMessage,
            BaseMessageHeader,
            BaseMessageBody,
        },
        methods: {
            onDontShowMeChenge(e) {
                this.$emit('dontShowMeChenge', e)
            }
        }
    }
</script>

<style scoped>
    .message-container {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 10000000000;
    }
</style>