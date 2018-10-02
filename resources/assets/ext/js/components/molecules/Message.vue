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
        <BaseMessageHeader @closeClick="$emit('closeClick')">
            <slot name="header"></slot>
            <button
                class="delete is-paddingless"
                aria-label="delete"
                @click.stop="$emit('closeClick')"
            ></button>
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
    import BaseMessage from '../atoms/BaseMessage'
    import BaseMessageHeader from '../atoms/BaseMessageHeader'
    import BaseMessageBody from '../atoms/BaseMessageBody'
    import BaseCheckBox from "../atoms/BaseCheckBox";

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