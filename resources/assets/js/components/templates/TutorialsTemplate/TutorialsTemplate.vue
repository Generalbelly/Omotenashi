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
                    @click="$emit('click:add')"
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
    import DataTable from "../../molecules/DataTable/DataTable";
    import SearchField from "../../atoms/fields/SearchField/SearchField";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";
    import Heading from "../../atoms/Heading/Heading";

    export default {
        name: "TutorialsTemplate",
        components: {
            Heading,
            AddButton,
            SearchField,
            DataTable,
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
            tutorialEntities: {
                type: Array,
                default() {
                    return [];
                },
            },
            total: {
                type: Number,
                default: 0,
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                columns: [
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
                ]
            }
        }
    }
</script>

<style scoped>

</style>