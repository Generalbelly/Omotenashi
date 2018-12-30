export default {
    props: {
        isRounded: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        styleClasses() {
            return {
                'is-rounded': this.isRounded,
            }
        }
    }
}
