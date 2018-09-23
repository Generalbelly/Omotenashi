<template>
    <div
        class="message__container"
        @click.stop.prevent="$emit('closeClick')"
    >
        <article
            class="message"
            :class="messageClass"
            @click.stop.prevent=""
        >
            <div
                class="message-header"
            >
                <slot name="header">{{ header }}</slot>
                <button
                    class="delete is-paddingless"
                    aria-label="delete"
                    @click.stop.prevent="$emit('closeClick')"
                ></button>
            </div>
            <div
                class="message-body"
            >
                <slot name="body">{{ body }}</slot>
                <p v-if="hasDontShowMeOption" class="has-margin-top-3">
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            :checked="dontShowMeChecked"
                            :true-value="true"
                            :false-value="false"
                            @click="$emit('dontShowMeChecked', $event.target.checked)"
                        >
                        Don't show me this message again.
                    </label>
                </p>

            </div>
        </article>
    </div>
</template>
<script>
export default {
    props: {
        header: {
            type: String,
            default: '',
        },
        body: {
            type: String,
            default: '',
        },
        messageClasses: {
            type: Array,
            default() {
                return []
            }
        },
        hasDontShowMeOption: {
            type: Boolean,
            default: false,
        },
        dontShowMeChecked: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        messageClass() {
            return this.convertArrayToObject(this.messageClasses);
        },
    },
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
    .message {
        min-width: 30vw;
        max-width: 50vw;
    }
</style>