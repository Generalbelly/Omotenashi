<template>
    <a
        v-if="href"
        class="button is-link"
        v-bind="$attrs"
    >
        <slot></slot>
    </a>
    <button
        v-else
        class="button"
        :class="classes"
        @click.stop.prevent="$emit('click')"
    >
        <template v-if="icon">
            <base-icon :icon="icon"></base-icon>
            <span>
                <slot></slot>
            </span>
        </template>
        <template v-else>
            <slot></slot>
        </template>
    </button>
</template>

<script>
    import { convertKeysFromCamelToKebab } from "../../../utils";
    import colorable from '../../mixins/colorable';
    import sizable from '../../mixins/sizable';
    import BaseIcon from "../BaseIcon/BaseIcon";

    export default {
        name: 'BaseButton',
        components: {
            BaseIcon
        },
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
            isWhite: {
                type: Boolean,
                default: false,
            },
            isLight: {
                type: Boolean,
                default: false,
            },
            isDark: {
                type: Boolean,
                default: false,
            },
            isBlack: {
                type: Boolean,
                default: false,
            },
            isText: {
                type: Boolean,
                default: false,
            },
            icon: {
                type: String,
                default: null,
            },
            href: {
                type: String,
                default: null,
            }
        },
        computed: {
            classes() {
                const { icon, ...classes } = this.$props
                return convertKeysFromCamelToKebab(classes)
            }
        }
    }
</script>
