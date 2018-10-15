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
            v-show="isDeletingTutorial"
            :tutorial="selectedTutorial ? selectedTutorial : null"
            @closeClick="updateUserAction('beingHome')"
            @deleteClick="onDeleteConfirmTutorialClick"
        >
        </DeleteConfirmationMessage>

        <DriverEditor
            ref="editor"
            class="driver-editor"
            :steps="selectedTutorial ? selectedTutorial.steps : []"
            :is-highlight-selection-active="isAddingStep"
            @saveClick="e => $emit('stepSaveClick', e)"
            @cancelClick="updateUserAction('beingHome')"
            @previewDone="updateUserAction('beingHome')"
            @editDone="updateUserAction('beingHome')"
        >
        </DriverEditor>

        <Setting
            v-show="isEditingTutorial || isAddingTutorial"
            :tutorial="isEditingTutorial ? selectedTutorial : null"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateUserAction('beingHome')"
        >
        </Setting>

        <Message
            v-show="selectorChoicesAvailableMessageShown"
            :has-dont-show-me-option="true"
            :dont-show-me="dontShowMeChecked('selectorChoicesAvailable')"
            is-info
            @closeClick="hideMessage"
            @dontShowMeChenge="removeMessage"
        >
            <template slot="header">Tips</template>
            <template slot="body">
                Selections start small.<br>
                The more you click, the larger your section to edit will become.<br>
                To select a different small section, press cancel and click a new section.
            </template>
        </Message>

        <Message
            v-show="noStepAddedYetMessageShown"
            is-warning
            @closeClick="hideMessage"
        >
            <template slot="header">Oops</template>
            <template slot="body">
                You haven't added any steps yet.
            </template>
        </Message>

        <Message
            v-show="noMoreSelectorChoicesMessageShown"
            is-warning
            @closeClick="hideMessage"
        >
            <template slot="header">Oops</template>
            <template slot="body">
                Looks like we don't have any other options to show you.
            </template>
        </Message>

        <Message
            v-show="clickToCreateStepMessageShown"
            :has-dont-show-me-option="true"
            :dont-show-me="dontShowMeChecked('clickToCreateStep')"
            is-info
            @closeClick="hideMessage"
            @dontShowMeChenge="removeMessage"
        >
            <template slot="header">Tips</template>
            <template slot="body">
                Click to select and edit text.
            </template>
        </Message>
        <LoadingModal v-show="isRequesting"></LoadingModal>
    </div>
</template>
<script>
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import Message from '../molecules/Message'
    import LoadingModal from '../molecules/LoadingModal'
    import Menu from '../organisms/Menu'
    import Setting from '../organisms/Setting'
    import DeleteConfirmationMessage from "../organisms/DeleteConfirmationMessage";
    import DriverEditor from "../organisms/DriverEditor";
    import BaseButton from "../atoms/BaseButton";

    export const messageKeys = {
        clickToCreateStep: 'clickToCreateStep',
        selectorChoicesAvailable: 'selectorChoicesAvailable',
        noStepAddedYet: 'noStepAddedYet',
        noMoreSelectorChoices: 'noMoreSelectorChoices',
    }

    export const userActions = {
        beingHome: 'beingHome',
        addingTutorial: 'addingTutorial',
        editingTutorial: 'editingTutorial',
        deletingTutorial: 'deletingTutorial',
        addingStep: 'addingStep',
        editingStep: 'editingStep',
        previewing: 'previewing',
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
            Message,
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
            showMessage(messageKey = null) {
                if (Object.values(messageKeys).includes(messageKey) && !this.dontShowMeChecked(messageKey)) {
                    this.messageShown = messageKey
                }
            },
            hideMessage() {
                this.messageShown = null
            },
            dontShowMeChecked(messageKey) {
                return (this.extLog.checkedMessages && this.extLog.checkedMessages.includes(messageKey));
            },
            removeMessage() {
                this.saveLog({
                    checkedMessages: [
                        ...this.extLog.checkedMessages,
                        this.messageShown,
                    ]
                })
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
                if (this.selectedTutorial.steps.length === 0) {
                    this.showMessage(messageKeys.noStepAddedYet)
                    return
                }
                this.updateUserAction(userActions.previewing)
                this.$refs.editor.preview()
            },
        },
        watch: {
            userAction(newValue, oldValue) {
                switch (newValue) {
                    case userActions.addingStep:
                        this.showMessage(messageKeys.clickToCreateStep)
                        break
                    default:
                }
            },
            tutorials(newValue, oldValue) {
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
            isEditingStep() {
                return (this.userAction === userActions.editingStep)
            },
            isPreviewing() {
                return (this.userAction === userActions.previewing)
            },
            selectorChoicesAvailableMessageShown() {
                return (this.messageShown === messageKeys.selectorChoicesAvailable)
            },
            noStepAddedYetMessageShown() {
                return (this.messageShown === messageKeys.noStepAddedYet)
            },
            noMoreSelectorChoicesMessageShown() {
                return (this.messageShown === messageKeys.noMoreSelectorChoices)
            },
            clickToCreateStepMessageShown() {
                return (this.messageShown === messageKeys.clickToCreateStep)
            },
        },
    }
</script>
<style scoped>
    .menu {
        min-width: 30vw;
        max-width: 30vw;
        width: 30vw;
        z-index: 10000000;
    }
    .driver-editor {
        height: 50px;
        z-index: 100000000;
    }
</style>