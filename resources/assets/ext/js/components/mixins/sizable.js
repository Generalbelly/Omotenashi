import { convertKeysFromCamelToKebab } from "../../utils";

const props = {
    isSmall: {
        type: Boolean,
        default: false,
    },
    isMedium: {
        type: Boolean,
        default: false,
    },
    isLarge: {
        type: Boolean,
        default: false,
    },
}

export default {
    props,
    computed: {
        sizableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
