<template>
    <div class="section">
        <heading>Projects</heading>
        <div class="level has-margin-bottom-5">
            <div class="level-left">
                <search-field
                    :value="query"
                    @input="$emit('change:query', $event)"
                    @click:search="$emit('click:search')"
                ></search-field>
            </div>
            <div class="level-right">
                <add-button
                    @click="$emit('click:add-button')"
                ></add-button>
            </div>
        </div>
        <data-table
            :pagination="pagination"
            :data="entities"
            :loading="isLoading"
            :total="total"
            @change:pagination="$emit('change:pagination', $event)"
            @select="$emit('select', $event)"
        >
            <template slot-scope="{row}">
                <b-table-column
                    field="name"
                    label="Name"
                    sortable
                >
                    {{ row.name }}
                </b-table-column>
                <b-table-column
                    field="domain"
                    label="Domain"
                    sortable
                >
                    {{ row.domain }}
                </b-table-column>
                <b-table-column
                    field="created_at"
                    label="Created at"
                    sortable
                >
                    {{ row.created_at }}
                </b-table-column>
            </template>
        </data-table>
    </div>
</template>

<script>
    import DataTable from "../../molecules/DataTable/DataTable";
    import SearchField from "../../molecules/SearchField/SearchField";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";
    import Heading from "../../atoms/Heading/Heading";

    export default {
        name: "ProjectsTemplate",
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
            entities: {
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
        }
    }
</script>

<style scoped>

</style>