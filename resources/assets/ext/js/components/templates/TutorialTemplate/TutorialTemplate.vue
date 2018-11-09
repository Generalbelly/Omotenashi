<template>
    <div>
        <Menu
            v-show="isHome"
            class="menu"
            :class="{
                'is-fixed-bottom-right': menuIsOnTheRight,
                'is-fixed-bottom-left': !menuIsOnTheRight
            }"
            :tutorials="tutorials"
            :selected-tutorial="selectedTutorial"
            :selected-step="selectedStep"
            @tutorialChange="e => $emit('tutorialChange', e)"
            @closeClick="$emit('closeClick')"
            @previewClick="onPreviewClick"
            @addStepClick="onAddStepClick"
            @stepClick="onStepClick"
            @deleteStepClick="onDeleteStepClick"
            @addTutorialClick="onAddTutorialClick"
            @editTutorialClick="onEditTutorialClick"
            @deleteTutorialClick="onDeleteTutorialClick"
            @switchSideClick="menuIsOnTheRight = !menuIsOnTheRight"
        ></Menu>

        <DeleteConfirmationMessage
            v-if="isDeletingTutorial"
            :tutorial="selectedTutorial"
            @closeClick="updateUserAction('beingHome')"
            @deleteClick="onDeleteConfirmTutorialClick"
        >
        </DeleteConfirmationMessage>

        <DriverEditor
            ref="editor"
            :steps="selectedTutorial ? selectedTutorial.steps : []"
            :has-selector-choices-available-message="!dontShowMeChecked('selectorChoicesAvailable')"
            :has-click-to-add-step-message="!dontShowMeChecked('clickToAddStep')"
            :is-highlight-selection-active="isAddingStep"
            @saveClick="e => $emit('stepSaveClick', e)"
            @cancelClick="updateUserAction('beingHome')"
            @previewDone="updateUserAction('beingHome')"
            @editDone="updateUserAction('beingHome')"
            @dontShowMeChange="removeMessage"
        >
        </DriverEditor>

        <Setting
            v-show="isEditingTutorial || isAddingTutorial"
            :tutorial="isEditingTutorial ? selectedTutorial : null"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateUserAction('beingHome')"
        >
        </Setting>

        <LoadingModal v-show="isRequesting"></LoadingModal>
    </div>
</template>
<script>
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import LoadingModal from '../../../../../js/components/molecules/LoadingModal'
    import Menu from '../../organisms/Menu'
    import Setting from '../../organisms/Setting'
    import DeleteConfirmationMessage from "../../organisms/DeleteConfirmationMessage"
    import DriverEditor from "../../organisms/DriverEditor"
    import BaseButton from "../../../../../js/components/atoms/BaseButton"

    export const userActions = {
        beingHome: 'beingHome',
        addingTutorial: 'addingTutorial',
        editingTutorial: 'editingTutorial',
        deletingTutorial: 'deletingTutorial',
        addingStep: 'addingStep',
    }

    export default {
        props: {
            tutorials: {
                type: Array,
                default() {
                    return []
                }
            },
            selectedTutorial: {
                type: Object,
                default: null,
            },
            selectedStep: {
                type: Object,
                default: null,
            },
            isRequesting: {
                type: Boolean,
                default: false,
            },
            extLog: {
                type: Object,
                default() {
                    return {};
                },
            }
        },
        components: {
            LoadingModal,
            DriverEditor,
            BaseButton,
            DeleteConfirmationMessage,
            Menu,
            Setting,
        },
        data() {
            return {
                userAction: userActions.beingHome,
                messageShown: null,
                menuIsOnTheRight: true,
            }
        },
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog'
            ]),
            updateUserAction(userAction = null) {
                if (Object.values(userActions).includes(userAction)) {
                    this.userAction = userAction
                }
            },
            dontShowMeChecked(messageKey) {
                return (this.extLog.checkedMessages && this.extLog.checkedMessages.includes(messageKey));
            },
            removeMessage({ messageKey, value }) {
                if (value) {
                    this.saveLog({
                        checkedMessages: [
                            ...this.extLog.checkedMessages,
                            messageKey,
                        ]
                    })
                } else {
                    const index = this.extLog.checkedMessages.findIndex(key => key === messageKey)
                    this.saveLog({
                        checkedMessages: [
                            ...this.extLog.checkedMessages.slice(0, index),
                            ...this.extLog.checkedMessages.slice(index+1),
                        ]
                    })
                }
            },
            onAddStepClick() {
                this.updateUserAction(userActions.addingStep)
            },
            onAddTutorialClick() {
                this.updateUserAction(userActions.addingTutorial)
            },
            onDeleteTutorialClick() {
                this.updateUserAction(userActions.deletingTutorial)
            },
            onDeleteConfirmTutorialClick(id) {
                this.$emit('deleteTutorialConfirmClick', { id })
                this.updateUserAction(userActions.deletingTutorial)
            },
            onTutorialSaveClick(tutorial) {
                this.$emit('tutorialSaveClick', tutorial)
                this.updateUserAction(userActions.beingHome)
            },
            onEditTutorialClick() {
                this.updateUserAction(userActions.editingTutorial)
            },
            onStepClick(id) {
                this.$refs.editor.highlight({ id })
                this.updateUserAction(userActions.editingStep)
                this.$emit('stepClick', { id })
            },
            onDeleteStepClick(id) {
                this.$emit('deleteStepClick', { id })
            },
            onPreviewClick() {
                this.updateUserAction(userActions.previewing)
                this.$refs.editor.preview()
            },
        },
        watch: {
            tutorials(newValue, oldValue) {
                console.log(newValue);
                console.log(oldValue);
                if ((oldValue.length - newValue.length) === 1) {
                    this.updateUserAction('beingHome')
                }
            },
        },
        computed: {
            isHome() {
                return (this.userAction === userActions.beingHome)
            },
            isAddingStep() {
                return (this.userAction === userActions.addingStep)
            },
            isAddingTutorial() {
                return (this.userAction === userActions.addingTutorial)
            },
            isEditingTutorial() {
                return (this.userAction === userActions.editingTutorial)
            },
            isDeletingTutorial() {
                return (this.userAction === userActions.deletingTutorial)
            },
        },
    }
</script>
<style scoped>
    .menu {
        z-index: 10000000;
    }

    @media only screen and (max-width: 600px) {
        .menu {
            width: 100%;
        }
    }
</style>