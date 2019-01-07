<template>
    <projects-template
        :query="query"
        :pagination="pagination"
        :entities="projects"
        :is-loading="isRequesting"
        @select="onProjectSelect"
        @click:search="onClickSearch"
        @change:query="onChangeQuery"
        @change:pagination="onChangePagination"
        @click:add-button="onClickAddButton"
    >
    </projects-template>
</template>

<script>
    import { mapActions, mapState, mapGetters } from 'vuex'
    import ProjectsTemplate from "../../templates/ProjectsTemplate/ProjectsTemplate"
    export default {
        name: "ProjectsPage",
        components: {
            ProjectsTemplate
        },
        data() {
            return {
                query: null,
                pagination: {
                    page: 0,
                    perPage: 20,
                    orderBy: ['created_at', 'desc'],
                    total: 0,
                },
            }
        },
        computed: {
            ...mapState('project', [
                'projects',
                'isRequesting',
                'total',
            ]),
        },
        created() {
            this.listProjects()
        },
        methods: {
            ...mapActions('project',[
                'listProjects',
                'deleteProject',
            ]),
            onProjectSelect(projectEntity) {
                this.$router.push({
                    name: 'projects.show',
                    params: {
                        id: projectEntity.id,
                    }
                })
            },
            onChangePagination(pagination) {
                this.pagination = {
                    ...pagination,
                    orderBy: `${pagination.orderBy[0]} ${pagination.orderBy[1]}`,
                };
                this.listProjects({
                    pagination: this.pagination,
                })
            },
            onChangeQuery(query) {
                this.query = query
            },
            onClickSearch() {
                this.listProjects({
                    ...this.pagination,
                    q: this.query,
                })
            },
            onClickAddButton() {
                this.$router.push({
                    name: 'projects.create',
                })
            }
        }
    }
</script>

<style scoped>
</style>