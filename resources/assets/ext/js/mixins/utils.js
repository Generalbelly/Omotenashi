export default {
    methods: {
        convertArrayToObject(array, value=true) {
            if (!Array.isArray(array)) return {}
            return array.reduce((a, c) => {
                return {
                    ...a,
                    [c]: value,
                }
            }, {})
        },
    },
};
