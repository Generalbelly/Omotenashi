<template>
    <button
        class="button"
        :class="buttonClasses"
        v-bind="$attrs"
        @click.stop.prevent="$emit('click')"
    >
        <slot></slot>
    </button>
</template>

<script>
    import colorable from '../../../mixins/colorable';
    import sizable from '../../../mixins/sizable';

    export default {
        name: 'BaseButton',
        mixins: [
            colorable,
            sizable,
        ],
        props: {
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
                    ...this.sizeClasses,
                    'is-outlined': this.isOutlined,
                    'is-fullwidth': this.isFullwidth,
                }
            }
        }
    }
</script>
