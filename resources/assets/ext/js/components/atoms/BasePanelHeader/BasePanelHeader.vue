<script>
    export default {
        name: "BasePanelHeader",
        props: {
            element: {
                type: String,
                default: 'p',
            },
        },
        render: function(createElement) {
            return createElement(
                this.element,
                {
                    class: {
                        'panel-heading': true
                    },
                },
                this.$slots.default
            )
        },
    }
</script>

<style scoped>
</style>