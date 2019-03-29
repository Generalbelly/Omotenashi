<template>
    <div
        :class="classes"
        v-bind="$attrs"
    >
        <slot></slot>
    </div>
</template>

<script>
    import { convertKeysFromCamelToKebab } from "../../../utils";

    export default {
        name: "BaseTile",
        props: {
            isAncestor: {
                type: Boolean,
                default: false,
            },
            isParent: {
                type: Boolean,
                default: false,
            },
            isChild: {
                type: Boolean,
                default: false,
            },
            isVertical: {
                type: Boolean,
                default: false,
            }
        },
        computed: {
            classes() {
                return {
                    'tile': true,
                    ...convertKeysFromCamelToKebab(this.$props),
                };
            }
        },
    }
</script>

<style scoped>
</style>