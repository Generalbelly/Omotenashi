import { convertKeysFromCamelToKebab } from "../../utils";

const props = {
    isPrimary: {
        type: Boolean,
        default: false,
    },
    isLink: {
        type: Boolean,
        default: false,
    },
    isInfo: {
        type: Boolean,
        default: false,
    },
    isSuccess: {
        type: Boolean,
        default: false,
    },
    isWarning: {
        type: Boolean,
        default: false,
    },
    isDanger: {
        type: Boolean,
        default: false,
    },
    isSecondary: {
        type: Boolean,
        default: false,
    }
}

export default {
    props,
    computed: {
        colorableProps() {
            return convertKeysFromCamelToKebab(props, this.$props)
        },
    }
}
