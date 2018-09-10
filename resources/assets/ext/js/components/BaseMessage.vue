<template>
    <div
        class="message__container"
        @click.stop.prevent="$emit('closeClick')"
    >
        <article
            class="message"
            :class="additionalMessageClass"
            @click.stop.prevent=""
        >
            <div class="message-header">
                <p>{{ header }}</p>
                <button
                    class="delete is-paddingless"
                    aria-label="delete"
                    @click.stop.prevent="$emit('closeClick')"
                ></button>
            </div>
            <div
                v-if="body"
                class="message-body"
            >
                {{ body }}
            </div>
            <div
                v-else
                class="message-body"
            >
                <slot></slot>
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
        messageClass: {
            type: Array,
            default() {
                return [];
            }
        },
    },
    computed: {
        additionalMessageClass() {
            if (this.messageClass.length) {
                return this.messageClass.reduce((a, c) => {
                    return {
                        ...a,
                        [c]: true,
                    }
                }, {});
            }
            return {};
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
    .message {
        min-width: 30vw;
    }
</style>