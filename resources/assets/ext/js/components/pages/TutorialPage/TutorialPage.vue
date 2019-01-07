<template>
    <tutorial-template
        :tutorial-entities="tutorialEntities"
        :selected-tutorial="selectedTutorial"
        :selected-step="selectedStep"
        :is-requesting="isRequesting"
        :ext-log="extLog"
        :url-did-change="urlDidChange"
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
                        const url = new URL(value.url);
                        this.path = url.pathname;
                    }
                    this.urlDidChange = false;
                }
            },
        },
        created() {
            this.startWatchingUrlForSPA()
            this.listTutorials({ url: window.location.href })
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
                const proxiedPushState = window.history.pushState
                window.history.pushState = function(stateObj, title, URL) {
                    const newPath = arguments[2]
                    if (newPath !== self.path) {
                        self.path = newPath
                        self.urlDidChange = true
                        self.listTutorials({ url: window.location.origin + newPath })
                    }
                    return proxiedPushState.apply(this, arguments)
                }
            }
        },
    }
</script>