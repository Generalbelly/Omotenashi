export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        rules: {
            type: String,
            default: '',
        },
    },
    watch: {
        errors(value) {
            console.log(value)
        },
        valid(value) {
            console.log(value)
        }
    },
    methods: {
        getType(errors, valid) {
            if (errors.length === 0 && valid) return 'is-success'
            if (errors.length > 0) return 'is-danger'
            return ''
        }
    }
}