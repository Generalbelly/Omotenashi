export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        rules: {
            type: [String, Object],
            default: '',
        },
    },
    methods: {
        getType(errors, valid) {
            if (errors.length === 0 && valid) return 'is-success'
            if (errors.length > 0) return 'is-danger'
            return ''
        }
    }
}