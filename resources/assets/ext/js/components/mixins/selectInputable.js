import { convertKeysFromCamelToKebab } from "../../utils";

const props = {
    isFullwidth: {
        type: Boolean,
        default: false,
    },
    items: {
        type: Array,
        default() {
            return []
        }
    },
    itemText: {
        type: String,
        default: 'text',
    },
    itemValue: {
        type: [String, Boolean, Number],
        default: 'value',
    },
    noItemSelectedText: {
        type: String,
        default: 'Select an item',
    }
}

export default {
    props,
    computed: {
        selectInputableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
