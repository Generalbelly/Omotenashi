export default {
    data() {
        return {
            serverErrors: {},
            clientErrors: {},
        }
    },
    watch: {
        errors: {
            deep: true,
            immediate: true,
            handler(value) {
                if (value) {
                    this.clientErrors = {
                        ...value.collect(),
                    }
                } else {
                    this.clientErrors = {}
                }
            }
        },
    },
    methods: {
        getErrors(key) {
            const errors = {
                ...this.clientErrors,
                ...this.serverErrors,
            }
            if (!errors[key]) return []
            return errors[key]
        },
        validate() {
            return new Promise(((resolve, reject) => {
                this.$validator.validate()
                    .then(result => {
                        resolve(result)
                    })
                    .catch(() => {
                        reject()
                    })
            }))
        },
    },
}
