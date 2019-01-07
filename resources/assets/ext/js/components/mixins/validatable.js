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
}