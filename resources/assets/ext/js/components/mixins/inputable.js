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
}

export default {
    props,
    computed: {
        inputableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
