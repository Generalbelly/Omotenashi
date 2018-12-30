<script>
    export default {
        name: "BaseHeader",
        props: {
            level: {
                type: Number,
                required: true
            },
        },
        render: function(createElement) {
            return createElement(
                'h' + this.level,
                {
                    class: {
                        'has-text-weight-bold': true
                    },
                    style: {
                        'font-size': '1.5em',
                    },
                },
                this.$slots.default // array of children
            )
        },
    }
</script>

<style scoped>
</style>