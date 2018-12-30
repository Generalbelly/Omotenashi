export default {
    props: {
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
    },
    computed: {
        colorClasses() {
            return {
                'is-primary': this.isPrimary,
                'is-link': this.isLink,
                'is-info': this.isInfo,
                'is-success': this.isSuccess,
                'is-warning': this.isWarning,
                'is-danger': this.isDanger,
            }
        }
    }
}
