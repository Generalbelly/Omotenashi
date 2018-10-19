export default {
    watch: {
        serverErrors: {
            deep: true,
            handler(value) {
                if (value) {
                    if (!this.$validator) return;
                    Object.keys(value).forEach(fieldName => {
                        const field = this.$validator.fields.find({ name: fieldName });
                        if (!field) return;
                        value[fieldName].forEach(msg => {
                            const error = {
                                id: field.id,
                                field: fieldName,
                                msg,
                            };
                            this.errors.add(error);
                        });

                        field.setFlags({
                            valid: !!value[fieldName].length,
                            dirty: true,
                        });
                    });
                }
            },
        }
    },
    computed: {
        serverErrors() {
            if (!this.$store) return {};
            return this.$store.state.serverErrors;
        }
    }
};