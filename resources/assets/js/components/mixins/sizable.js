export default {
    props: {
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
    },
    computed: {
        sizeClasses() {
            return {
                'is-small': this.isSmall,
                'is-medium': this.isMedium,
                'is-large': this.isLarge,
            }
        }
    }
}
