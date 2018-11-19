<template>
    <projects-template
        :table-items="projects"
        :table-columns="columns"
    >
    </projects-template>
</template>

<script>
    import { mapActions, mapState } from 'vuex'
    import ProjectsTemplate from "../../templates/ProjectsTemplate/ProjectsTemplate"
    export default {
        name: "ProjectsPage",
        components: {
            ProjectsTemplate
        },
        created() {
            this.listProjects({
                data: {}
            })
        },
        data() {
            return {
                columns: [
                    {
                        field: 'name',
                        label: 'Name',
                        customKey: 'id',
                    },
                    {
                        field: 'domain',
                        label: 'Domain',
                        customKey: 'id',
                    },
                    {
                        field: 'created_at',
                        label: 'Created at',
                        customKey: 'id',
                    },
                ]
            }
        },
        computed: {
            ...mapState('project', [
                'projects',
            ])
        },
        methods: {
            ...mapActions('project',[
                'listProjects',
                'addProject',
                'updateProject',
                'deleteProject',
            ])
        }
    }
</script>

<style scoped>

</style>