<template>
    <tutorials-template
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
    </tutorials-template>
</template>

<script>
    import { mapActions, mapState, mapGetters } from 'vuex';
    import TutorialsTemplate from "../../templates/TutorialsTemplate";

    export default {
        name: "TutorialsPage",
        components: {
            TutorialsTemplate,
        },
        props: {
            id: {
                type: String,
                default: null,
            },
        },
        data() {
            return {
                breadcrumb: []
            }
        },
        computed: {
            ...mapState('project', [
                'projectEntity',
                'requestState',
            ]),
            ...mapGetters('project', [
                'isRequesting',
            ])
        },
        created() {
            if (this.id) {
                this.getProject({
                    id: this.id,
                }).then(() => {
                    this.breadcrumb = [
                        {
                            text: 'Projects',
                            to: '/projects',
                            exact: true,
                        },
                        {
                            text: this.projectEntity.name,
                            to: this.projectEntity.id,
                            exact: true,
                            isActive: true,
                        }
                    ]
                })
            }
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
                    }).then(() => {
                        this.$router.push({
                            name: 'projects.show',
                            params: {
                                id: this.projectEntity.id,
                            }
                        })
                    })
                }
            },
            onDelete(projectEntity) {
                this.deleteProject({
                    id: projectEntity.id,
                }).then(() => {
                    this.$router.push({
                        name: 'projects.index',
                    })
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