<template>
    <b-table
        v-bind="$attrs"
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
                        <frown-icon size="is-large">
                        </frown-icon>
                    </p>
                    <p>No items found</p>
                </div>
            </section>
        </template>
        <template
            v-for="slot in Object.keys($scopedSlots)"
            :slot="slot"
            slot-scope="scope"
        >
            <slot
                :name="slot"
                v-bind="scope"
            >
            </slot>
        </template>
    </b-table>
</template>

<script>
    import FrownIcon from "../../atoms/icons/FrownIcon";
    export default {
        name: 'DataTable',
        components: {FrownIcon},
        props: {
            data: {
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

<style>

</style>