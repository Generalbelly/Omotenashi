export default {
    props: {
        isWhite: {
            type: Boolean,
            default: false,
        },
        isBlack: {
            type: Boolean,
            default: false,
        },
        isLight: {
            type: Boolean,
            default: false,
        },
        isDark: {
            type: Boolean,
            default: false,
        },
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
        isSuccessful: {
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
        hasBackgroundGrey: {
            type: Boolean,
            default: false,
        },
        hasBackgroundWhite: {
            type: Boolean,
            default: false,
        },
        hasTextWhite: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        colorClasses() {
            return {
                'is-white': this.isWhite,
                'is-black': this.isBlack,
                'is-light': this.isLight,
                'is-dark': this.isDark,
                'is-primary': this.isPrimary,
                'is-link': this.isLink,
                'is-info': this.isInfo,
                'is-success': this.isSuccess,
                'is-successful': this.isSuccessful,
                'is-warning': this.isWarning,
                'is-danger': this.isDanger,
                'has-background-grey': this.hasBackgroundGrey,
                'has-background-white': this.hasBackgroundWhite,
                'has-text-white': this.hasTextWhite,
            }
        }
    }
}
