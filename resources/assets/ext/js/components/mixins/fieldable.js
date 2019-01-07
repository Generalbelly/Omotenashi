import { convertKeysFromCamelToKebab } from "../../utils";

const props = {
    readonly: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: null,
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
    messages: {
        type: Array,
        default() {
            return [];
        }
    },
}

export default {
    props,
    computed: {
        fieldableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
