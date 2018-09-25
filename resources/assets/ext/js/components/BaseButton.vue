<template>
    <button
        class="button"
        :class="buttonClasses"
        :id="id"
        :disabled="disabled"
        @click.stop.prevent="$emit('click')"
    >
        <slot></slot>
    </button>
</template>
<script>
    export default {
        name: 'BaseButton',
        props: {
            id: {
                type: String,
                default: null,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            href: {
                type: String,
                default: null,
            },
            isOutlined: {
                type: Boolean,
                default: false,
            },
            isFullwidth: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            buttonClasses() {
                return {
                    ...this.colorClasses,
                    'is-outlined': this.isOutlined,
                    'is-fullwidth': this.isFullwidth,
                }
            }
        }
    }
</script>
