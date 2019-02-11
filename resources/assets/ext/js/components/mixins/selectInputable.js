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
        type: String,
        default: 'value',
    },
}

export default {
    props,
    computed: {
        selectInputableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
