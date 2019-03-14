<template>
    <tutorial-template
        :tutorial-entities="tutorialEntities"
        :selected-tutorial="selectedTutorial"
        :selected-step="selectedStep"
        :request-state="requestState"
        :is-requesting="isRequesting"
        :ext-log="extLog"
        :show-url-change-alert="urlDidChange"
        @tutorialSaveClick="onTutorialSaveClick"
        @tutorialChange="onTutorialChange"
        @closeClick="$emit('click:close')"
        @stepClick="selectStep"
        @deleteStepClick="deleteStep"
        @stepSaveClick="onStepSaveClick"
        @deleteTutorialConfirmClick="deleteTutorial"
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
                        this.path = value.path;
                    }
                    this.urlDidChange = false;
                }
            },
        },
        created() {
            this.startWatchingUrlForSPA()
            this.listTutorials({
                url: window.parent.location.href
            })
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
                'saveLog'
            ]),
            onTutorialSaveClick({ id=null, name='', description='', steps=[], url='' }) {
                const data = {
                    name,
                    description,
                    steps,
                    url,
                    project_id: this.projectEntity.id,
                }
                if (id) {
                    this.updateTutorial({
                        id,
                        data,
                    })
                } else {
                    this.addTutorial({
                        data,
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
                        self.listTutorials({ url: window.parent.location.origin + newPath })
                    }
                    return proxiedPushState.apply(this, arguments)
                }
            }
        },
    }
</script>