<template>
    <div @click.stop.self="$emit('closeClick')">
        <article
            class="message"
        >
            <slot></slot>
        </article>
    </div>
</template>
<script>
export default {
    name: 'BaseMessage',
    props: {
        isFixedTopRight: {
            type: Boolean,
            default: false,
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
        messageClass() {
            return {
                ...this.colorClass,
                'is-fixed-top-right': this.isFixedTopRight,
                'is-fixed-top-left': this.isFixedTopLeft,
                'is-fixed-bottom-right': this.isFixedBottomRight,
                'is-fixed-bottom-left': this.isFixedBottomLeft,
            }
        },
    }
}
</script>

<style scoped>
</style>