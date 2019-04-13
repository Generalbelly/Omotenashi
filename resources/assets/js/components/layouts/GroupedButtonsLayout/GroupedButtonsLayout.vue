<template>
    <div
        class="buttons"
        :class="classes"
    >
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: 'GroupedButtonsLayout',
        props: {
            isRight: {
                type: Boolean,
                default: false,
            },
            isLeft: {
                type: Boolean,
                default: false,
            }
        },
        computed: {
            classes() {
                return {
                    [this.class]: !!this.class,
                    'is-right': this.isRight,
                    'is-left': this.isLeft,
                }
            }
        }
    };
</script>

<style>

</style>