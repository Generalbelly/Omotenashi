<template>
    <tutorial-template
        :project-entity="projectEntity"
        :tutorial-entities="tutorialEntities"
        :selected-tutorial="selectedTutorial"
        :selected-step="selectedStep"
        :request-state="requestState"
        :is-requesting="isRequesting"
        :ext-log="extLog"
        :show-url-change-alert.sync="urlDidChange"
        @click:save="onClickSave"
        @tutorialChange="onTutorialChange"
        @closeClick="$emit('click:close')"
        @stepClick="selectStep"
        @deleteStepClick="deleteStep"
        @stepSaveClick="onStepSaveClick"
        @deleteTutorialConfirmClick="deleteTutorial"
        @click:retry="onClickRetry"
        :show-project-not-found-modal="projectNotFound"
    >
    </tutorial-template>
</template>
<script>
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import TutorialTemplate from '../../templates/TutorialTemplate'
    import tutorial from "../../../store/modules/tutorial";

    export default {
        components: {
            TutorialTemplate
        },
        data() {
            return {
                urlDidChange: false,
                path: null,
            };
        },
        computed: {
            ...mapState('tutorial', [
                'projectEntity',
                'tutorialEntities',
                'selectedTutorialId',
                'selectedStepId',
                'requestState',
                'isRequesting',
                'projectNotFound',
            ]),
            ...mapState([
                'extLog'
            ]),
            ...mapGetters('tutorial', [
                'selectedTutorial',
                'selectedStep',
            ]),
        },
        watch: {
            selectedTutorial: {
                deep: true,
                handler(value) {
                    if (value) {
                        this.path = value.path
                    }
                    this.urlDidChange = false
                }
            },
        },
        created() {
            this.startWatchingUrlForSPA()
            this.list()
        },
        methods: {
            ...mapActions('tutorial', [
                'listTutorials',
                'addTutorial',
                'updateTutorial',
                'deleteTutorial',
                'selectTutorial',
                'selectStep',
                'addStep',
                'updateStep',
                'deleteStep',
            ]),
            ...mapActions([
                'retrieveLog',
                'saveLog',
            ]),
            list(params={}) {
                this.listTutorials({
                    url: window.parent.location.href,
                    ...params,
                })
            },
            onClickSave(data) {
                const {
                    id = null,
                    steps = [],
                    parameters = [],
                    path = {},
                    name,
                    description,
                } = data
                if (id) {
                    this.updateTutorial({
                        data: {
                            id,
                            name,
                            description,
                            steps,
                            path,
                            parameters
                        },
                        id
                    })
                } else {
                    this.addTutorial({
                        data: {
                            name,
                            description,
                            steps,
                            path,
                            parameters,
                            project_id: this.projectEntity.id,
                        }
                    })
                }
            },
            onTutorialChange(id) {
                this.selectTutorial({ id });
            },
            onStepSaveClick({ id, element, popover }) {
                if (id) {
                    this.updateStep({
                        data: {
                            element,
                            popover,
                        },
                        id,
                    })
                } else {
                    this.addStep({
                        data: {
                            element,
                            popover,
                        },
                    })
                }
            },
            startWatchingUrlForSPA() {
                const self = this;
                const proxiedPushState = window.parent.history.pushState
                window.parent.history.pushState = function(stateObj, title, URL) {
                    const newPath = arguments[2]
                    if (newPath !== self.path) {
                        self.path = newPath
                        self.urlDidChange = true
                        self.list({ url: window.parent.location.origin + newPath })
                    }
                    return proxiedPushState.apply(this, arguments)
                }
            },
            onClickRetry() {
                this.list()
            }
        },
    }
</script>