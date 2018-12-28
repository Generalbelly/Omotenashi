<template>
    <b-table
        :data="data"
        :columns="columns"
        :per-page="pagination.perPage"
        :default-sort="pagination.orderBy"
        hoverable
        striped
        mobile-cards
        paginated
        backend-pagination
        backend-sorting
        @page-change="onPageChange"
        @sort="onSort"
        @select="onSelect"
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
                    <p>No items found</p>
                </div>
            </section>
        </template>
    </b-table>
</template>

<script>
    export default {
        name: "ProjectTable",
        props: {
            data: {
                type: Array,
                default() {
                    return []
                }
            },
            pagination: {
                type: Object,
                default() {
                    return {
                        page: 0,
                        perPage: 20,
                        orderBy: [],
                        total: 0,
                    }
                }
            }
        },
        data() {
            return {
                columns: [
                    {
                        field: 'name',
                        label: 'Name',
                        sortable: true,
                    },
                    {
                        field: 'domain',
                        label: 'Domain',
                        sortable: true,
                    },
                    {
                        field: 'created_at',
                        label: 'Created at',
                        sortable: true,
                    }
                ],
            }
        },
        methods: {
            onSelect(e) {
                this.$emit('select', e);
            },
            onPageChange(page) {
                this.emitPagination({
                    page,
                })
            },
            onSort(column, direction) {
                this.emitPagination({
                    orderBy: [column, direction],
                })
            },
            emitPagination(data) {
                this.$emit('change:pagination', {
                    ...this.pagination,
                    ...data,
                });
            }
        }
    }
</script>

<style scoped>

</style>