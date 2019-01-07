<template>
    <div>
        <heading class="has-margin-bottom-5">Projects</heading>
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
            :columns="columns"
            :loading="isLoading"
            :total="total"
            @change:pagination="$emit('change:pagination', $event)"
            @select="$emit('select', $event)"
        >
            <!--<template slot-scope="{row}">-->
                <!--<b-table-column-->
                    <!--field="name"-->
                    <!--label="Name"-->
                    <!--sortable-->
                <!--&gt;-->
                    <!--{{ row.name }}-->
                <!--</b-table-column>-->
                <!--<b-table-column-->
                    <!--field="domain"-->
                    <!--label="Domain"-->
                    <!--sortable-->
                <!--&gt;-->
                    <!--{{ row.domain }}-->
                <!--</b-table-column>-->
                <!--<b-table-column-->
                    <!--field="created_at"-->
                    <!--label="Created at"-->
                    <!--sortable-->
                <!--&gt;-->
                    <!--{{ row.created_at }}-->
                <!--</b-table-column>-->
            <!--</template>-->
        </data-table>
        <router-view></router-view>
        <div v-if="entities.length > 0">
            <div class="notification has-text-centered is-size-4">
                Have you installed our chrome extension yet?<br>
                It is required to create tutorials.
                <div class="has-margin-5">
                    <a
                        class="button is-complementary"
                        href=""
                        target="_blank"
                    >
                        Install the extension
                    </a>
                </div>
            </div>
        </div>
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
                    },
                ]
            }
        }
    }
</script>

<style scoped>

</style>