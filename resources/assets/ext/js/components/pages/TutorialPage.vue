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
        @deleteClick="deleteTutorial(selectedTutorial)"
        @stepChange="selectStep"
    >
    </TutorialTemplate>
</template>
<script>
    import uuidv4 from 'uuid';
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import TutorialTemplate from '../templates/TutorialTemplate'
    import tutorial from "../../store/modules/tutorial";

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
            onTutorialSaveClick({ id=null, name='', description='', steps=[] }) {
                const data = {
                    name,
                    description,
                    steps,
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
                // this.updateUserAction(userActions.onMenu)
            },
            onTutorialChange(id) {
                this.selectTutorial({ id });
            },
            onStepSaveClick(step) {
                if (this.selectedStepId) {
                    this.updateStep({
                        id: this.selectedStepId,
                        element,
                        popover,
                    })
                } else {
                    this.addStep({
                        id: uuidv4(),
                        element,
                        popover,
                    })
                }
                console.log('onStepSaveClick')
            },
            // onSameElementSelect(step) {
            //     this.selectStep(step.id)
            // },
            onPreviewClick() {
                console.log('onPreviewClick')
            },

        },
        watch: {
            // tutorials(newValue, oldValue) {
            //     if ((oldValue.length - newValue.length) === 1) {
            //         this.updateUserAction('onMenu')
            //     }
            // },
        },
    }
</script>