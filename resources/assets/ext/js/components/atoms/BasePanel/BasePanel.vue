<script>
    export default {
        name: "BasePanel",
        props: {
            element: {
                type: String,
                default: 'nav',
            },
        },
        render: function(createElement) {
            return createElement(
                this.element,
                {
                    class: {
                        'panel': true
                    },
                },
                this.$slots.default // array of children
            )
        },
    }
</script>

<style scoped>
</style>