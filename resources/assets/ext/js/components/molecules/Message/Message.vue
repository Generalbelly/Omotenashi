<template>
    <div @click.stop.self="$emit('closeClick')" class="message__container">
        <base-message
            @closeClick="$emit('closeClick')"
            :class="messageClasses"
        >
            <base-message-header>
                <slot name="header"></slot>
                <button
                    v-if="close"
                    class="delete is-paddingless"
                    aria-label="delete"
                    @click.stop="$emit('closeClick')"
                ></button>
            </base-message-header>
            <base-message-body>
                <slot name="body"></slot>
                <p v-if="hasDontShowMeOption" class="has-margin-top-3">
                    <base-check-box
                        :value="dontShowMe"
                        @change="onDontShowMeChenge"
                    >
                        Don't show me this message again.
                    </base-check-box>
                </p>
            </base-message-body>
        </base-message>
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
            close: {
                type: Boolean,
                default: false,
            }
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