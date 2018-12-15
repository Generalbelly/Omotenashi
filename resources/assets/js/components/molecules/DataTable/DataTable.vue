<template>
    <b-table
        v-bind="$attrs"
        :data="items"
        :columns="columns"
        :per-page="pagination.perPage"
        :default-sort="pagination.orderBy"
        bordered
        hoverable
        mobile-cards
        paginated
        backend-pagination
        backend-sorting
        @page-change="onPageChange"
        @sort="onSort"
        @select="onSelect"
    >
        <slot>
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
                        <p>No projects</p>
                    </div>
                </section>
            </template>
            <template slot-scope="props">
                <b-table-column
                    v-for="column in columns"
                    :key="column.label"
                    :field="column.field"
                    :label="column.label"
                    :numeric="column.numeric"
                    :sortable="column.sortable"
                >
                    <router-link
                        v-if="column.to"
                        :to="column.to(props.row)"
                    >
                        {{ props.row[column.field] }}
                    </router-link>
                    <span v-else>
                        {{ props.row[column.field] }}
                    </span>
                </b-table-column>
            </template>
        </slot>
    </b-table>
</template>

<script>
    export default {
        props: {
            items: {
                type: Array,
                default() {
                    return []
                }
            },
            columns: {
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
    };
</script>
