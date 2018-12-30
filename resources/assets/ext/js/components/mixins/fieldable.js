export default {
    props: {
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
    },
}
