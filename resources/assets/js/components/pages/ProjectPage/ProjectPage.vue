<template>
    <project-template
        :project-entity="projectEntity"
        :is-loading="isRequesting"
        :breadcrumb="breadcrumb"
        @click:save="onSave"
        @click:cancel="onCancel"
        @click:delete="onDelete"
        @click:ga-connect="onClickGAConnect"
        @click:ga-delete="onClickGADelete"
        @click:ga-property-edit="onClickGAPropetyEdit"
    >
    </project-template>
</template>

<script>
    import { mapActions, mapState } from 'vuex';
    import ProjectTemplate from "../../templates/ProjectTemplate"

    import {
        REQUEST_GET_PROJECT_SUCCESS,
        REQUEST_DELETE_PROJECT_SUCCESS,
    } from '../../../store/mutation-types';
    export default {
        name: "ProjectPage",
        components: {
            ProjectTemplate
        },
        data() {
            return {
                breadcrumb: []
            }
        },
        computed: {
            ...mapState('project', [
                'projectEntity',
                'isRequesting',
                'requestState',
            ]),
        },
        watch: {
            requestState(value) {
                if (value === REQUEST_DELETE_PROJECT_SUCCESS) {
                    this.$router.push({
                        name: 'projects.index',
                    })
                } else if (value === REQUEST_GET_PROJECT_SUCCESS) {
                    this.breadcrumb = [
                        {
                            text: 'Projects',
                            to: '/projects',
                            exact: true,
                        },
                        {
                            text: this.projectEntity.name,
                            to: this.$route.params.id,
                            exact: true,
                            isActive: true,
                        }
                    ]
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
                'deleteOAuth',
                'listGoogleAnalyticsAccounts',
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
            onCancel() {
                this.$router.push({
                    name: 'projects.index',
                })
            },
            onClickGAConnect() {
                window.location.href = `/oauths/google-analytics/redirect?id=${this.projectEntity.id}`
            },
            onClickGADelete(oauthEntity) {
                this.deleteOAuth({
                    id: oauthEntity.id,
                })
            },
            onClickGAPropetyEdit(projectId) {
                this.listGoogleAnalyticsAccounts({
                    id: projectId,
                })
            }
        }
    }
</script>

<style scoped>
</style>