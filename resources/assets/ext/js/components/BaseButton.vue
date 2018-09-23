<template>
    <button
        class="button"
        :id="id"
        :class="buttonClass"
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
            classes: {
                type: Array,
                default() {
                    return [];
                },
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            href: {
                type: String,
                default: null,
            }
        },
        computed: {
            buttonClass() {
                return this.convertArrayToObject(this.classes)
            },
        }
    }
</script>
