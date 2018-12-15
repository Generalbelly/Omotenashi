<template>
    <table class="table">
        <thead>
            <tr
                v-for="header in headers"
                :key="header[headerKey]"
            >
                <th>{{ header.text }}</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="item in items"
                :key="item[itemKey]"
            >
                <td>{{ item.text }}</td>
            </tr>
        </tbody>
        <tfoot>
            footer
        </tfoot>
    </table>
</template>

<script>
    export default {
        name: "BaseTable",
        props: {
            headers: {
                type: Array,
                default() {
                    return [];
                }
            },
            items: {
                type: Array,
                default() {
                    return [];
                }
            },
            headerKey: {
                type: String,
                default: 'text',
            },
            itemKey: {
                type: String,
                default: 'id',
            },
            pagination: {
                type: Object,
                default() {
                    return {
                        descending: false,
                        page: 1,
                        rowsPerPage: 20, // -1 for All
                        sortBy: '',
                        totalItems: 0,
                    };
                }
            }
        }
    }
</script>

<style scoped>

</style>