<template>
    <data-table
        :pagination="pagination"
        :data="tutorialEntities"
        :columns="columns"
        :loading="isLoading"
        :total="total"
        item-type="tutorial"
        v-bind="$attrs"
        @change:pagination="$emit('change:pagination', $event)"
        @select="$emit('select', $event)"
        @click:create-first="$emit('click:create-first-tutorial')"
    >
    </data-table>
</template>
<script>
    import Heading from "../../atoms/Heading";
    import SearchField from "../../atoms/fields/SearchField";
    import AddButton from "../../atoms/buttons/AddButton";
    import DataTable from "../../molecules/DataTable";

    const columns = [
        {
            field: 'name',
            label: 'Name',
            sortable: true,
        },
        // {
        //     field: 'description',
        //     label: 'Description',
        //     sortable: true,
        // },
        {
            field: 'path_in_text',
            label: 'Path',
            sortable: false,
        },
        {
            field: 'query',
            label: 'Parameters',
            sortable: false,
        },
        {
            field: 'created_at',
            label: 'Created at',
            sortable: true,
        },
    ];

    export default {
        name: 'TutorialTable',
        components: {
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
            tutorialEntities: {
                type: Array,
                default() {
                    return []
                },
            },
        },
        data() {
            return {
                columns: columns,
            }
        },
    }
</script>
<style scoped>
</style>