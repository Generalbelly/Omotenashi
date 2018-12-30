<template>
    <div @click.stop.self="$emit('closeClick')" class="message__container">
        <BaseMessage
            @closeClick="$emit('closeClick')"
            :class="messageClasses"
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
    </div>
</template>

<script>
    import colorable from '../../mixins/colorable'
    import BaseMessage from '../../atoms/BaseMessage'
    import BaseMessageHeader from '../../atoms/BaseMessageHeader'
    import BaseMessageBody from '../../atoms/BaseMessageBody'
    import BaseCheckBox from "../../atoms/BaseCheckBox"

    export default {
        name: "Message",
        mixins: [ colorable ],
        components: {
            BaseCheckBox,
            BaseMessage,
            BaseMessageHeader,
            BaseMessageBody,
        },
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
        computed: {
            messageClasses() {
                return {
                    ...this.colorClasses,
                    'is-fixed-top-right': this.isFixedTopRight,
                    'is-fixed-top-left': this.isFixedTopLeft,
                    'is-fixed-bottom-right': this.isFixedBottomRight,
                    'is-fixed-bottom-left': this.isFixedBottomLeft,
                }
            }
        },
        methods: {
            onDontShowMeChenge(e) {
                this.$emit('dontShowMeChange', e)
            }
        }
    }
</script>

<style scoped>
    .message__container {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 10000000000;
    }
</style>