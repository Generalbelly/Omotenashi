export default {
    props: {
        isHovered: {
            type: Boolean,
            default: false,
        },
        isFocused: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        stateClasses() {
            return {
                'is-hovered': this.isHovered,
                'is-focused': this.isFocused,
            }
        }
    }
}
