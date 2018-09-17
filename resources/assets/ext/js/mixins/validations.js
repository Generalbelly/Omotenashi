export default {
    data() {
        return {
            serverErrors: {},
        };
    },
    methods: {
        getErrors(key) {
            if (!(key && this.serverErrors)) return [];
            let errors = [];
            if (Object.keys(this.serverErrors).includes(key)) {
                const serverErrors = this.serverErrors[key];
                errors = [
                    ...errors,
                    ...serverErrors,
                ];
            }
            const clientErrors = this.errors.collect(key);
            if (clientErrors.length > 0) {
                errors = [
                    ...errors,
                    clientErrors,
                ];
            }
            return errors;
        },
        validate() {
            return new Promise(((resolve, reject) => {
                this.$validator.validateAll()
                    .then(result => {
                        resolve(result);
                    })
                    .catch(() => {
                        reject();
                    });
            }));
        },
    },
};