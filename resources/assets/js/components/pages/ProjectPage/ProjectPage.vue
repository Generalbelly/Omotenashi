<template>
    <project-template
        :project="project"
        :is-loading="isRequesting"
        @save="onSave"
        @back="onBack"
        @delete="onDelete"
    >
    </project-template>
</template>

<script>
    import { mapActions, mapState } from 'vuex';
    import ProjectTemplate from "../../templates/ProjectTemplate"

    import {
        REQUEST_ADD_PROJECT_SUCCESS,
        REQUEST_ADD_PROJECT_FAILURE,
        REQUEST_UPDATE_PROJECT_SUCCESS,
        REQUEST_UPDATE_PROJECT_FAILURE,
        REQUEST_DELETE_PROJECT_SUCCESS,
        REQUEST_DELETE_PROJECT_FAILURE,
    } from '../../../store/mutation-types';
    export default {
        name: "ProjectPage",
        components: {
            ProjectTemplate
        },
        computed: {
            ...mapState('project', [
                'project',
                'isRequesting',
                'requestState',
            ]),
        },
        watch: {
            requestState(value) {
                console.log(value)
                if (
                    value === REQUEST_ADD_PROJECT_SUCCESS ||
                    value === REQUEST_UPDATE_PROJECT_SUCCESS ||
                    value === REQUEST_DELETE_PROJECT_SUCCESS
                ) {
                    this.$router.push({
                        name: 'projects.index',
                    })
                } else if (
                    value === REQUEST_ADD_PROJECT_FAILURE ||
                    value === REQUEST_UPDATE_PROJECT_FAILURE ||
                    value === REQUEST_DELETE_PROJECT_FAILURE
                ) {
                    this.showServerErrors()
                }
            }
        },
        created() {
            this.getProject({
                id: this.$route.params.id,
            })
        },
        methods: {
            ...mapActions('project',[
                'addProject',
                'updateProject',
                'getProject',
                'deleteProject',
            ]),
            onSave(projectEntity) {
                if (projectEntity.id) {
                    this.updateProject({
                        data: projectEntity,
                        id: projectEntity.id,
                    })
                } else {
                    this.addProject({
                        data: projectEntity,
                    })
                }
            },
            onDelete(projectEntity) {
                this.deleteProject({
                    id: projectEntity.id,
                })
            },
            onBack() {
                this.$router.push({
                    name: 'projects.index',
                })
            },
            showServerErrors() {
                this.$snackbar.open({
                    position: 'is-top',
                    type: 'is-warning',
                    message: 'Saving failed.',
                })
            }
        }
    }
</script>

<style scoped>
</style>