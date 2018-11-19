<template>

    <data-table
        :items="tableItems"
        :columns="tableColumns"
        :is-loading="isLoading"
    ></data-table>
</template>

<script>
    import DataTable from "../../molecules/DataTable/DataTable";
    export default {
        name: "ProjectsTemplate",
        props: {
            tableItems: {
                type: Array,
                default() {
                    return [];
                },
            },
            tableColumns: {
                type: Array,
                default() {
                    return [];
                },
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
        },
        components: {
            DataTable
        }
    }
</script>

<style scoped>

</style>