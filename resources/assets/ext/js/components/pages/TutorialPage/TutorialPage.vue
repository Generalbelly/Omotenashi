<template>
    <TutorialTemplate
        :tutorials="tutorials"
        :selected-tutorial="selectedTutorial"
        :selected-step="selectedStep"
        :isRequesting="isRequesting"
        :extLog="extLog"
        @tutorialSaveClick="onTutorialSaveClick"
        @tutorialChange="onTutorialChange"
        @closeClick="$emit('closeClick')"
        @stepClick="selectStep"
        @deleteStepClick="deleteStep"
        @stepSaveClick="onStepSaveClick"
        @deleteTutorialConfirmClick="deleteTutorial"
    >
    </TutorialTemplate>
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
            return {}
        },
        computed: {
            ...mapState('tutorial', [
                'tutorials',
                'selectedTutorialId',
                'selectedStepId',
                'isRequesting',
            ]),
            ...mapState(['extLog']),
            ...mapGetters('tutorial', [
                'selectedTutorial',
                'selectedStep',
            ]),
        },
        methods: {
            ...mapActions('tutorial', [
                'getTutorials',
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
                }
                console.log(data)
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
        },
        created() {
            this.getTutorials();
        }
    }
</script>