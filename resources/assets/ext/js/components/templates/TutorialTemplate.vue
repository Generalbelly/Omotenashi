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
            @stepClick="e => $emit('stepClick', e)"
            @deleteStepClick="e => $emit('deleteStepClick', e)"
            @addTutorialClick="onAddTutorialClick"
            @editTutorialClick="onEditTutorialClick"
            @deleteTutorialClick="onDeleteTutorialClick"
            @switchSideClick="menuIsOnTheRight = !menuIsOnTheRight"
        ></Menu>

        <DeleteConfirmationMessage
            v-show="isDeletingTutorial"
            :tutorial="selectedTutorial ? selectedTutorial : null"
            @closeClick="updateUserAction('beingHome')"
            @deleteClick="e => $emit('deleteClick', e)"
        >
        </DeleteConfirmationMessage>

        <DriverEditor
            class="has-padding-4 is-fixed-bottom-right driver-editor"
            v-show="isEditingPopover"
            :tutorial="selectedTutorial"
            @saveClick="e => $emit('stepSaveClick', e)"
            @cancelClick="updateUserAction('beingHome')"
            @reset="updateUserAction('beingHome')"
            @sameElementSelect="e => $emit('stepChange', e)"
        >
        </DriverEditor>

        <Setting
            v-show="isEditingTutorial || isCreatingTutorial"
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
        creatingStep: 'creatingStep',
        creatingTutorial: 'creatingTutorial',
        editingTutorial: 'editingTutorial',
        deletingTutorial: 'deletingTutorial',
        editingPopover: 'editingPopover',
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
                this.updateUserAction(userActions.creatingStep)
            },
            onAddTutorialClick() {
                this.updateUserAction(userActions.creatingTutorial)
            },
            onDeleteTutorialClick() {
                this.updateUserAction(userActions.deletingTutorial)
            },
            onTutorialSaveClick(tutorial) {
                this.$emit('tutorialSaveClick', tutorial)
                this.updateUserAction(userActions.beingHome)
            },
            onEditTutorialClick() {
                this.updateUserAction(userActions.editingTutorial)
            },
            onPreviewClick() {
                if (this.selectedTutorial.steps.length === 0) {
                    this.showMessage(messageKeys.noStepAddedYet)
                    return
                }
                this.updateUserAction(userActions.previewing)
                this.preview()
            },
        },
        watch: {
            userAction(newValue, oldValue) {
                switch (newValue) {
                    // case userActions.beingHome:
                    //     if (oldValue === userActions.previewing) {
                    //         this.driver.options.allowClose = false
                    //         this.driver.options.onReset = () => {}
                    //     }
                    //
                    //     if (oldValue === userActions.editingPopover) {
                    //         this.driver.reset()
                    //         this.driver.options.isEditMode = false
                    //
                    //         this.selectorChoices = []
                    //         this.selectorChoiceIndex = 0
                    //     }
                    //     break
                    case userActions.creatingStep:
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
            isCreatingStep() {
                return (this.userAction === userActions.creatingStep)
            },
            isCreatingTutorial() {
                return (this.userAction === userActions.creatingTutorial)
            },
            isEditingTutorial() {
                return (this.userAction === userActions.editingTutorial)
            },
            isDeletingTutorial() {
                return (this.userAction === userActions.deletingTutorial)
            },
            isEditingPopover() {
                return (this.userAction === userActions.editingPopover)
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