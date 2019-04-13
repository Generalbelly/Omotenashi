<template>
    <data-table
        :pagination="pagination"
        :data="projectEntities"
        :loading="isLoading"
        :total="total"
        :hoverable="!detailOpen"
        @change:pagination="$emit('change:pagination', $event)"
        detailed
        detail-key="id"
        show-detail-icon
        @details-open="onDetailsOpen"
        @details-close="onDetailsClose"
        @click:create-first="$emit('click:create-first-project')"
    >
        <template slot-scope="props">
            <b-table-column
                v-for="column in columns"
                :key="column.field"
                :field="column.field"
                :label="column.label"
                :sortable="column.sortable"
            >
                <template v-if="column.label === 'Actions'">
                    <grouped-buttons-layout>
                        <pen-icon
                            class="has-cursor-pointer has-margin-right-3"
                            @click="$emit('click:edit', props.row)"
                        ></pen-icon>
                        <trash-icon
                            class="has-cursor-pointer"
                            @click="$emit('click:delete', props.row)"
                        ></trash-icon>
                    </grouped-buttons-layout>
                </template>
                <template v-else>
                    {{ props.row[column.field] }}
                </template>
            </b-table-column>
        </template>
        <template slot="detail" slot-scope="props">
            <tutorial-table
                :paginated="false"
                :tutorial-entities="props.row.tutorialEntities"
                :is-loading="isLoading"
                :hoverable="false"
                @click:create-first-tutorial="$emit('click:create-first-tutorial', props.row)"
            >
            </tutorial-table>
        </template>
    </data-table>
</template>
<script>
    import Heading from "../../atoms/Heading";
    import SearchField from "../../atoms/fields/SearchField";
    import AddButton from "../../atoms/buttons/AddButton";
    import DataTable from "../../molecules/DataTable";
    import PenIcon from "../../atoms/icons/PenIcon";
    import TrashIcon from "../../atoms/icons/TrashIcon";
    import GroupedButtonsLayout from "../../layouts/GroupedButtonsLayout";
    import TutorialTable from "../TutorialTable/TutorialTable";

    const columns = [
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
        },
        {
            field: null,
            label: 'Actions',
            sortable: false
        }
    ]

    export default {
        name: 'ProjectTable',
        components: {
            TutorialTable,
            GroupedButtonsLayout,
            TrashIcon,
            PenIcon,
            DataTable,
            AddButton,
            SearchField,
            Heading
        },
        props: {
            query: {
                type: String,
                default: null,
            },
            pagination: {
                type: Object,
                default() {
                    return {}
                }
            },
            total: {
                type: Number,
                default: 0,
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
            projectEntities: {
                type: Array,
                default() {
                    return []
                },
            },
        },
        data() {
            return {
                columns: columns,
                detailOpen: false,
            }
        },
        methods: {
            onDetailsOpen(row) {
                this.detailOpen = true
                this.$emit('details-open', row)
            },
            onDetailsClose(row) {
                this.detailOpen = false
            }
        }
    }
</script>
<style scoped>
</style>