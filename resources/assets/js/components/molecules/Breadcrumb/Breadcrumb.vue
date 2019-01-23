<template>
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <template v-for="item in items">
                <li
                    :class="{ 'is-active': item.isActive }"
                >
                    <router-link
                        :to="item.to"
                        :exact="item.exact"
                    >
                        {{ item.text }}
                    </router-link>
                </li>
            </template>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Breadcrumb",
        props: {
            items: {
                type: Array,
                default() {
                    return [];
                }
            }
        }
    }
</script>

<style scoped>

</style>