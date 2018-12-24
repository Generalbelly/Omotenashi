<template>
    <project-template
        :project="project"
        :is-loading="isRequesting"
        @save="onSave"
        @back="onBack"
    >
    </project-template>
</template>

<script>
    import { mapActions, mapState } from 'vuex';
    import ProjectTemplate from "../../templates/ProjectTemplate"

    import {
        REQUEST_ADD_PROJECT,
        REQUEST_ADD_PROJECT_SUCCESS,
        REQUEST_ADD_PROJECT_FAILURE,
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
            requestState(newValue, oldValue) {
                if (oldValue === REQUEST_ADD_PROJECT) {
                    if (newValue === REQUEST_ADD_PROJECT_SUCCESS) {
                        this.$router.push({
                            name: 'projects.index',
                        })
                    } else if (newValue === REQUEST_ADD_PROJECT_FAILURE) {
                        this.$snackbar.open({
                            position: 'is-top',
                            type: 'is-warning',
                            message: 'Saving failed.',
                        })
                    }
                }
            }
        },
        created() {
            if (this.$route.params.id) {
                this.getProject({
                    id: this.$route.params.id,
                })
            }
        },
        methods: {
            ...mapActions('project',[
                'addProject',
                'updateProject',
                'getProject',
            ]),
            onSave(projectEntity) {
                this.addProject({
                    data: projectEntity,
                })
            },
            onBack() {
                this.$router.push({
                    name: 'projects.index',
                })
            }
        }
    }
</script>

<style scoped>
</style>