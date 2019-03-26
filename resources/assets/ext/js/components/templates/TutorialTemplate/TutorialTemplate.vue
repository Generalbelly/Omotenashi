<template>
    <div>
        <tutorial-list
            v-show="isHome"
            class="menu"
            :class="{
                'is-fixed-bottom-right': menuIsOnTheRight,
                'is-fixed-bottom-left': !menuIsOnTheRight,
            }"
            :is-loading="requestState === 'REQUEST_LIST_TUTORIALS'"
            :tutorial-entities="tutorialEntities"
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
        ></tutorial-list>

        <delete-confirmation-message
            v-if="isDeletingTutorial"
            :tutorial="selectedTutorial"
            @closeClick="updateState('beingHome')"
            @deleteClick="onDeleteConfirmTutorialClick"
        >
        </delete-confirmation-message>

        <driver-editor
            ref="editor"
            :steps="selectedTutorial ? selectedTutorial.steps : []"
            :has-selector-choices-available-message="!dontShowMeChecked('selectorChoicesAvailable')"
            :has-click-to-add-step-message="!dontShowMeChecked('clickToAddStep')"
            :is-highlight-selection-active="isAddingStep"
            @saveClick="onEditorSaveClick"
            @cancelClick="onEditorCancelClick"
            @previewDone="updateState('beingHome')"
            @editDone="updateState('beingHome')"
            @dontShowMeChange="removeMessage"
        >
        </driver-editor>

        <validation-observer ref="observer">
            <setting
                slot-scope="{invalid}"
                v-show="isEditingTutorial || isAddingTutorial"
                :id="innerTutorialEntity.id"
                :path="innerTutorialEntity.path"
                :name="innerTutorialEntity.name"
                :description="innerTutorialEntity.description"
                :steps="innerTutorialEntity.steps"
                :parameters="innerTutorialEntity.parameters"
                :origin="origin"
                @update:name="onTutorialUpdate('name', $event)"
                @update:description="onTutorialUpdate('description', $event)"
                @update:steps="onTutorialUpdate('steps', $event)"
                @update:parameters="onTutorialUpdate('parameters', $event)"
                @update:path="onTutorialUpdate('path', $event)"
                @click:save="onClickSave"
                @click:cancel="onClickCancel"
            >
            </setting>
        </validation-observer>

        <message
            v-show="showUrlChangeAlert && requestState === 'REQUEST_LIST_TUTORIALS'"
            is-warning
            @closeClick="$emit('update:show-url-change-alert', false)"
        >
            <template slot="header">Alert</template>
            <template slot="body">
               Tutorials must be created per URL.<br>
                Now fetching tutorials for this page.
            </template>
        </message>

        <loading-modal
            v-show="isRequesting && requestState !== 'REQUEST_LIST_TUTORIALS'"
        ></loading-modal>

        <project-not-found-modal
            v-show="showProjectNotFoundModal"
            @click:retry="$emit('click:retry')"
            :isRequesting="isRequesting"
        >
        </project-not-found-modal>
    </div>
</template>
<script>
    import { ValidationObserver } from 'vee-validate'
    import { mapActions } from 'vuex'
    import LoadingModal from '../../molecules/LoadingModal'
    import TutorialList from '../../organisms/TutorialList'
    import Setting from '../../organisms/Setting'
    import DeleteConfirmationMessage from "../../organisms/DeleteConfirmationMessage"
    import DriverEditor from "../../organisms/DriverEditor"
    import Message from "../../molecules/Message";
    import ProjectNotFoundModal from "../../organisms/ProjectNotFoundModal";
    import TutorialEntity from "../../../../../js/components/atoms/Entities/TutorialEntity";
    import ProjectEntity from "../../../../../js/components/atoms/Entities/ProjectEntity";

    export const states = {
        beingHome: 'beingHome',
        addingTutorial: 'addingTutorial',
        editingTutorial: 'editingTutorial',
        deletingTutorial: 'deletingTutorial',
        addingStep: 'addingStep',
        editingStep: 'editingStep',
        previewing: 'previewing',
    }

    export default {
        name: 'TutorialTemplate',
        components: {
            ValidationObserver,
            ProjectNotFoundModal,
            Message,
            LoadingModal,
            DriverEditor,
            DeleteConfirmationMessage,
            TutorialList,
            Setting,
        },
        props: {
            projectEntity: {
                type: Object,
                default() {
                    return new ProjectEntity()
                }
            },
            tutorialEntities: {
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
            requestState: {
                type: String,
                default: false,
            },
            extLog: {
                type: Object,
                default() {
                    return {};
                },
            },
            showUrlChangeAlert: {
                type: Boolean,
                default: false,
            },
            showProjectNotFoundModal: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                state: states.beingHome,
                messageShown: null,
                menuIsOnTheRight: true,
                innerTutorialEntity: new TutorialEntity()
            }
        },
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog'
            ]),
            updateState(state = null) {
                if (Object.values(states).includes(state)) {
                    this.state = state
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
                this.addUserScreenClickHandler()
                this.updateState(states.addingStep)
            },
            onEditorSaveClick(step) {
                this.removeUserScreenClickHandler()
                this.$emit('stepSaveClick', step)
                this.updateState(states.beingHome)
            },
            onEditorCancelClick() {
                this.removeUserScreenClickHandler()
                this.updateState(states.beingHome)
            },
            addUserScreenClickHandler() {
                document.querySelectorAll( 'body *' ).forEach(el => {
                    if (el.tagName === 'A') {
                        el.style.pointerEvents = 'none';
                        el.style.cursor = 'default';
                    }
                    el.addEventListener('click', this.$refs.editor.userScreenClickHandler)
                })
            },
            removeUserScreenClickHandler() {
                document.querySelectorAll( 'body *' ).forEach(el => {
                    if (el.tagName === 'A') {
                        el.style.pointerEvents = null;
                        el.style.cursor = null;
                    }
                    el.removeEventListener('click', this.$refs.editor.userScreenClickHandler)
                })
            },
            onAddTutorialClick() {
                this.innerTutorialEntity = new TutorialEntity()
                this.$refs.observer.reset()
                this.updateState(states.addingTutorial)
            },
            onDeleteTutorialClick() {
                this.updateState(states.deletingTutorial)
            },
            onDeleteConfirmTutorialClick(id) {
                this.$emit('deleteTutorialConfirmClick', { id })
                this.updateState(states.deletingTutorial)
            },
            onTutorialUpdate(key, value) {
                this.innerTutorialEntity = new TutorialEntity({
                    ...this.innerTutorialEntity,
                    [key]: value,
                })
            },
            onClickSave() {
                this.$refs.observer.validate()
                    .then(result => {
                        if (result) {
                            this.$emit('click:save', this.innerTutorialEntity)
                            this.updateState(states.beingHome)
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onClickCancel() {
                if (this.state === states.addingTutorial) {
                    this.innerTutorialEntity = new TutorialEntity()
                }
                this.updateState(states.beingHome)
            },
            onEditTutorialClick() {
                this.innerTutorialEntity = new TutorialEntity({
                    ...this.selectedTutorial,
                })
                this.updateState(states.editingTutorial)
            },
            onStepClick(id) {
                this.$refs.editor.highlight({ id })
                this.updateState(states.editingStep)
                this.$emit('stepClick', { id })
            },
            onDeleteStepClick(id) {
                this.$emit('deleteStepClick', { id })
            },
            onPreviewClick() {
                this.updateState(states.previewing)
                this.$refs.editor.preview()
            },
        },
        watch: {
            tutorialEntities(newValue, oldValue) {
                if ((oldValue.length - newValue.length) === 1) {
                    this.updateState(states.beingHome)
                }
            },
        },
        computed: {
            isHome() {
                return (this.state === states.beingHome)
            },
            isAddingStep() {
                return (this.state === states.addingStep)
            },
            isAddingTutorial() {
                return (this.state === states.addingTutorial)
            },
            isEditingTutorial() {
                return (this.state === states.editingTutorial)
            },
            isDeletingTutorial() {
                return (this.state === states.deletingTutorial)
            },
            origin() {
                if (this.projectEntity) {
                    return `${this.projectEntity.protocol}://${this.projectEntity.domain}`
                }
                return null;
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