<template>
    <div
        :class="classes"
        class="select"
    >
        <select v-model="inputValue">
            <option
                v-for="(item, itemIndex) in items"
                :key="itemIndex"
                :value="item[itemValue]"
                :selected="item[itemValue] === value"
            >
                {{ item[itemText] }}
            </option>
        </select>
    </div>
</template>

<script>
    import colorable from '../../mixins/colorable'
    import sizable from '../../mixins/sizable'
    import statable from '../../mixins/statable'
    import selectInputable from '../../mixins/selectInputable'

    export default {
        name: "BaseSelectInput",
        mixins: [
            colorable,
            sizable,
            statable,
            selectInputable
        ],
        props: {
            itemValue: {
                type: String,
                default: 'value',
            },
            value: {
                type: [String, Boolean, Number],
                default: null,
            },
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
                    'is-fullwidth': this.isFullwidth,
                }
            },
        }
    }
</script>