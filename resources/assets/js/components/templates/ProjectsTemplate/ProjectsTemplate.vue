<template>
    <div class="section">
        <div class="level">
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
            :items="entities"
            :columns="columns"
            :loading="isLoading"
            :total="total"
            @change:pagination="$emit('change:pagination', $event)"
            @select="$emit('select', $event)"
        ></data-table>
    </div>
</template>

<script>
    import DataTable from "../../molecules/DataTable/DataTable";
    import SearchField from "../../molecules/SearchField/SearchField";
    import AddButton from "../../molecules/AddButton/AddButton";
    export default {
        name: "ProjectsTemplate",
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
            columns: {
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
        components: {
            AddButton,
            SearchField,
            DataTable
        }
    }
</script>

<style scoped>

</style>