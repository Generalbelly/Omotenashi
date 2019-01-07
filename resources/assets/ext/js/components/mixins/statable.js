import { convertKeysFromCamelToKebab } from "../../utils";

const props = {
    isHovered: {
        type: Boolean,
        default: false,
    },
    isFocused: {
        type: Boolean,
        default: false,
    },
}

export default {
    props,
    computed: {
        statableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
