<template>
    <div>
        <heading>Tutorials</heading>
        <div class="level has-margin-bottom-5">
            <div class="level-left">
                <search-field
                    :value="query"
                    @input="$emit('change:query', $event)"
                    search-button-class="is-primary-050"
                    @click:search="$emit('click:search')"
                ></search-field>
            </div>
            <div class="level-right">
                <add-button
                    @click="$emit('click:add-button')"
                    class="is-primary"
                ></add-button>
            </div>
        </div>
        <data-table
            :pagination="pagination"
            :data="tutorialEntities"
            :columns="columns"
            :loading="isLoading"
            :total="total"
            @change:pagination="$emit('change:pagination', $event)"
            @select="$emit('select', $event)"
        >
        </data-table>
    </div>
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
        {
            field: 'path',
            label: 'Path',
            sortable: true,
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