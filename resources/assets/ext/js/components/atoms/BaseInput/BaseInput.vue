<template>
    <input
        v-bind="inputableProps"
        class="input"
        :class="classes"
        v-model="inputValue"
    >
</template>

<script>
    import colorable from '../../mixins/colorable'
    import sizable from '../../mixins/sizable'
    import statable from '../../mixins/statable'
    import inputable from '../../mixins/inputable'

    export default {
        name: "BaseInput",
        mixins: [
            colorable,
            sizable,
            statable,
            inputable,
        ],
        props: {
            value: {
                type: String,
                default: null,
            },
            isStatic: {
                type: Boolean,
                default: false,
            },
            isRounded: {
                type: Boolean,
                default: false,
            }
        },
        computed: {
            inputValue: {
                get() {
                    return this.value
                },
                set(newValue) {
                    this.$emit('input', newValue)
                }
            },
            classes() {
                return {
                    ...this.colorableProps,
                    ...this.sizableProps,
                    ...this.statableProps,
                    'is-static': this.isStatic,
                    'is-rounded': this.isRounded,
                }
            },
        }
    }
</script>

<style scoped>
</style>