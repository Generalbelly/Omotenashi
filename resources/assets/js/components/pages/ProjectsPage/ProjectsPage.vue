<template>
    <projects-template
        :query="query"
        :pagination="pagination"
        :project-entities="projectEntities"
        :is-loading="isRequesting"
        @click:edit="onClickEdit"
        @click:search="onClickSearch"
        @change:query="onChangeQuery"
        @change:pagination="onChangePagination"
        @details-open="onDetailsOpen"
        @click:add="onClickAdd"
        @click:create-first-project="onClickAdd"
        @click:create-first-tutorial="onClickCreateFirstTutorial"
    >
    </projects-template>
</template>

<script>
    import { mapActions, mapState, mapGetters } from 'vuex'
    import ProjectsTemplate from "../../templates/ProjectsTemplate/ProjectsTemplate"
    import { debounce } from 'debounce'

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
                'projectEntities',
                'total',
            ]),
            ...mapGetters('project', [
                'isRequesting',
            ])
        },
        created() {
            this.listProjects()
        },
        methods: {
            ...mapActions('project',[
                'listProjects',
                'deleteProject',
            ]),
            ...mapActions('tutorial', [
                'listTutorials',
            ]),
            onClickEdit(projectEntity) {
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
            search: debounce(function(params){
                this.listProjects(params);
            }, 250),
            onChangeQuery(query) {
                this.query = query;
                this.search({
                    ...this.pagination,
                    q: this.query,
                });
            },
            onClickSearch() {
                this.search({
                    ...this.pagination,
                    q: this.query,
                });
                // this.listProjects({
                //     ...this.pagination,
                //     q: this.query,
                // })
            },
            onClickAdd() {
                this.$router.push({
                    name: 'projects.create',
                })
            },
            onDetailsOpen(projectEntity) {
                this.listTutorials({
                    projectId: projectEntity.id
                })
            },
            onClickCreateFirstTutorial(projectEntity) {
                // window.open(
                //     `/projects/${projectEntity.id}/tutorials/create`,
                // )
                this.$router.push({
                    name: 'tutorials.create',
                    params: {
                        projectId: projectEntity.id,
                    }
                })
            }
        }
    }
</script>

<style scoped>
</style>