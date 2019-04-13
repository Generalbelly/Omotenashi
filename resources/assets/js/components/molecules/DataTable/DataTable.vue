<template>
    <b-table
        v-bind="$attrs"
        :data="data"
        :columns="columns"
        :per-page="pagination.perPage"
        :default-sort="pagination.orderBy"
        :hoverable="hoverable"
        :striped="striped"
        :mobile-cards="mobileCards"
        :paginated="paginated"
        :backend-pagination="backendPagination"
        :backend-sorting="backendSorting"
        @page-change="onPageChange"
        @sort="onSort"
        @select="onSelect"
        @details-open="onDetailsOpen"
        @details-close="onDetailsClose"
    >
        <template slot="empty">
            <section class="section">
                <div class="content has-text-grey has-text-centered">
<!--                    <p>-->
<!--                        <frown-icon size="is-large">-->
<!--                        </frown-icon>-->
<!--                    </p>-->
                    <p>No {{ itemType }} found</p>
                    <create-first-button
                        @click="$emit('click:create-first')"
                    >Create your first {{ itemType }}</create-first-button>
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
    import AddButton from "../../atoms/buttons/AddButton/AddButton";
    import CreateFirstButton from "../../atoms/buttons/CreateFirstButton/CreateFirstButton";
    export default {
        name: 'DataTable',
        components: {CreateFirstButton, AddButton, FrownIcon},
        props: {
            itemType: {
                type: String,
                default: 'project',
            },
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
            },
            hoverable: {
                type: Boolean,
                default: true,
            },
            striped: {
                type: Boolean,
                default: true,
            },
            mobileCards: {
                type: Boolean,
                default: true,
            },
            paginated: {
                type: Boolean,
                default: true,
            },
            backendPagination: {
                type: Boolean,
                default: true,
            },
            backendSorting: {
                type: Boolean,
                default: true,
            },
        },
        methods: {
            onSelect(row, oldRow) {
                this.$emit('select', row)
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
            onDetailsOpen(row) {
                this.$emit('details-open', row)
            },
            onDetailsClose(row) {
                this.$emit('details-close', row)
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