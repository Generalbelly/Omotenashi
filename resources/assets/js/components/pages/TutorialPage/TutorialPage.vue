<template>
    <tutorial-template
        :tutorial-entity="tutorialEntity"
        :is-loading="isRequesting || isSendingMessageToExtension"
        :breadcrumb="breadcrumb"
        @click:save="onSave"
        @click:cancel="onCancel"
        @click:delete="onDelete"
        @click:ga-connect="onClickGAConnect"
        @click:ga-delete="onClickGADelete"
        @click:ga-property-edit="onClickGAPropetyEdit"
    >
    </tutorial-template>
</template>

<script>
    import { mapActions, mapState, mapGetters } from 'vuex';
    import TutorialTemplate from "../../templates/TutorialTemplate";

    export default {
        name: "TutorialPage",
        components: {
            TutorialTemplate
        },
        props: {
            id: {
                type: String,
                default: null,
            },
            projectId: {
                type: String,
                default: null,
            },
        },
        data() {
            return {
                breadcrumb: [],
                isSendingMessageToExtension: false,
            }
        },
        computed: {
            ...mapState('tutorial', [
                'tutorialEntity',
                'requestState',
            ]),
            ...mapGetters('tutorial', [
                'isRequesting',
            ])
        },
        created() {
            if (this.id) {
                this.getTutorial({
                    id: this.id,
                }).then(() => {
                    this.breadcrumb = [
                        {
                            text: 'Tutorials',
                            to: '/tutorials',
                            exact: true,
                        },
                        {
                            text: this.tutorialEntity.name,
                            to: this.tutorialEntity.id,
                            exact: true,
                            isActive: true,
                        }
                    ]
                })
            } else {
                this.redirectTutorial({
                    projectId: this.projectId,
                }).then(response => {
                    const { data } = response
                    this.isSendingMessageToExtension = true
                    if (chrome.runtime) {
                        chrome.runtime.sendMessage(process.env.CHROME_EXTENSION_ID, {
                            app: process.env.APP_NAME,
                            message: {
                                state: 'coming',
                                tutorialUrl: data.url,
                            },
                        }, (response) => {
                            if (response && response.state === 'success') {
                                window.open(
                                    data.url,
                                    '_blank'
                                );
                            } else {
                                // TODO Track Error
                            }
                            this.isSendingMessageToExtension = false
                        })
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        methods: {
            ...mapActions('tutorial',[
                'addTutorial',
                'updateTutorial',
                'getTutorial',
                'deleteTutorial',
                'deleteOAuth',
                'redirectTutorial',
                'listGoogleAnalyticsAccounts',
            ]),
            onSave(tutorialEntity) {
                if (tutorialEntity.id) {
                    this.updateTutorial({
                        data: tutorialEntity,
                        id: tutorialEntity.id,
                    })
                } else {
                    this.addTutorial({
                        data: tutorialEntity,
                    }).then(() => {
                        this.$router.push({
                            name: 'tutorials.show',
                            params: {
                                id: this.tutorialEntity.id,
                            }
                        })
                    })
                }
            },
            onDelete(tutorialEntity) {
                this.deleteTutorial({
                    id: tutorialEntity.id,
                }).then(() => {
                    this.$router.push({
                        name: 'tutorials.index',
                    })
                })
            },
            onCancel() {
                this.$router.push({
                    name: 'tutorials.index',
                })
            },
            onClickGAConnect() {
                window.location.href = `/oauths/google-analytics/redirect?id=${this.tutorialEntity.id}`
            },
            onClickGADelete(oauthEntity) {
                this.deleteOAuth({
                    id: oauthEntity.id,
                })
            },
            onClickGAPropetyEdit(tutorialId) {
                this.listGoogleAnalyticsAccounts({
                    id: tutorialId,
                })
            }
        }
    }
</script>

<style scoped>
</style>