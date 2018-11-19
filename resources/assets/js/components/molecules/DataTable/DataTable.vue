<template>
    <b-table
        :data="items"
        :columns="columns"
        :loading="isLoading"
        bordered
        hoverable
        mobile-cards
    >
        <template slot="empty">
            <section class="section">
                <div class="content has-text-grey has-text-centered">
                    <p>
                        <b-icon
                            icon="frown"
                            size="is-large"
                        >
                        </b-icon>
                    </p>
                    <p>Nothing here.</p>
                </div>
            </section>
        </template>
    </b-table>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default() {
                    return [];
                },
            },
            columns: {
                type: Array,
                default() {
                    return [];
                },
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {};
        },
    };
</script>
<style scoped>
</style>
