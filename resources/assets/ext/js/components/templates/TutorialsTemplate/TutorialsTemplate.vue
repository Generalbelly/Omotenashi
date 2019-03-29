<template>
    <div class="tutorials">
        <!--<tutorial-list-->
            <!--v-show="isHome"-->
            <!--class="menu"-->
            <!--:class="{-->
                <!--'is-fixed-bottom-right': menuIsOnTheRight,-->
                <!--'is-fixed-bottom-left': !menuIsOnTheRight,-->
            <!--}"-->
            <!--:is-loading="requestState === 'REQUEST_LIST_TUTORIALS'"-->
            <!--:tutorial-entities="tutorialEntities"-->
            <!--:selected-tutorial="selectedTutorial"-->
            <!--:selected-step="selectedStep"-->
            <!--@tutorialChange="e => $emit('tutorialChange', e)"-->
            <!--@closeClick="$emit('closeClick')"-->
            <!--@previewClick="onPreviewClick"-->
            <!--@addStepClick="onAddStepClick"-->
            <!--@stepClick="onStepClick"-->
            <!--@deleteStepClick="onDeleteStepClick"-->
            <!--@addTutorialClick="onAddTutorialClick"-->
            <!--@editTutorialClick="onEditTutorialClick"-->
            <!--@deleteTutorialClick="onDeleteTutorialClick"-->
            <!--@switchSideClick="menuIsOnTheRight = !menuIsOnTheRight"-->
        <!--&gt;</tutorial-list>-->
        <b-modal :active="isHome">
            <tutorial-table
                class="has-background-white has-padding-5"
                :query="query"
                :pagination="pagination"
                :tutorial-entities="tutorialEntities"
                :is-loading="isRequesting"
                @select="$emit('select', $event)"
                @click:search="$emit('click:search', $event)"
                @change:query="$emit('change:query', $event)"
                @change:pagination="$emit('change:pagination', $event)"
                @click:add-button="$emit('click:add-button', $event)"
            ></tutorial-table>
        </b-modal>

        <!--<delete-confirmation-message-->
            <!--v-if="isDeletingTutorial"-->
            <!--:tutorial="selectedTutorial"-->
            <!--@closeClick="updateState('beingHome')"-->
            <!--@deleteClick="onDeleteConfirmTutorialClick"-->
        <!--&gt;-->
        <!--</delete-confirmation-message>-->

        <!--<driver-editor-->
            <!--ref="editor"-->
            <!--:steps="selectedTutorial ? selectedTutorial.steps : []"-->
            <!--:has-selector-choices-available-message="!dontShowMeChecked('selectorChoicesAvailable')"-->
            <!--:has-click-to-add-step-message="!dontShowMeChecked('clickToAddStep')"-->
            <!--:is-highlight-selection-active="isAddingStep"-->
            <!--@saveClick="onEditorSaveClick"-->
            <!--@cancelClick="onEditorCancelClick"-->
            <!--@previewDone="updateState('beingHome')"-->
            <!--@editDone="updateState('beingHome')"-->
            <!--@dontShowMeChange="removeMessage"-->
        <!--&gt;-->
        <!--</driver-editor>-->

        <!--<validation-observer ref="observer">-->
            <!--<setting-->
                <!--slot-scope="{invalid}"-->
                <!--v-show="isEditingTutorial || isAddingTutorial"-->
                <!--:id="innerTutorialEntity.id"-->
                <!--:path="innerTutorialEntity.path"-->
                <!--:name="innerTutorialEntity.name"-->
                <!--:description="innerTutorialEntity.description"-->
                <!--:steps="innerTutorialEntity.steps"-->
                <!--:parameters="innerTutorialEntity.parameters"-->
                <!--:origin="origin"-->
                <!--@update:name="onTutorialUpdate('name', $event)"-->
                <!--@update:description="onTutorialUpdate('description', $event)"-->
                <!--@update:steps="onTutorialUpdate('steps', $event)"-->
                <!--@update:parameters="onTutorialUpdate('parameters', $event)"-->
                <!--@update:path="onTutorialUpdate('path', $event)"-->
                <!--@click:save="onClickSave"-->
                <!--@click:cancel="onClickCancel"-->
            <!--&gt;-->
            <!--</setting>-->
        <!--</validation-observer>-->

        <!--&lt;!&ndash;<message&ndash;&gt;-->
            <!--&lt;!&ndash;v-show="showUrlChangeAlert && requestState === 'REQUEST_LIST_TUTORIALS'"&ndash;&gt;-->
            <!--&lt;!&ndash;is-warning&ndash;&gt;-->
            <!--&lt;!&ndash;@closeClick="$emit('update:show-url-change-alert', false)"&ndash;&gt;-->
        <!--&lt;!&ndash;&gt;&ndash;&gt;-->
            <!--&lt;!&ndash;<template slot="header">Alert</template>&ndash;&gt;-->
            <!--&lt;!&ndash;<template slot="body">&ndash;&gt;-->
               <!--&lt;!&ndash;Tutorials must be created per URL.<br>&ndash;&gt;-->
                <!--&lt;!&ndash;Now fetching tutorials for this page.&ndash;&gt;-->
            <!--&lt;!&ndash;</template>&ndash;&gt;-->
        <!--&lt;!&ndash;</message>&ndash;&gt;-->

        <!--&lt;!&ndash;<loading-modal&ndash;&gt;-->
            <!--&lt;!&ndash;v-show="isRequesting && requestState !== 'REQUEST_LIST_TUTORIALS'"&ndash;&gt;-->
        <!--&lt;!&ndash;&gt;</loading-modal>&ndash;&gt;-->

        <!--<project-not-found-modal-->
            <!--v-show="showProjectNotFoundModal"-->
            <!--@click:retry="$emit('click:retry')"-->
            <!--:isRequesting="isRequesting"-->
        <!--&gt;-->
        <!--</project-not-found-modal>-->
    </div>
</template>
<script>
    import { ValidationObserver } from 'vee-validate'
    import { mapActions } from 'vuex'
    import LoadingModal from '../../molecules/LoadingModal'
    import Setting from '../../organisms/Setting'
    import DriverEditor from "../../organisms/DriverEditor"
    import Message from "../../molecules/Message";
    import ProjectNotFoundModal from "../../organisms/ProjectNotFoundModal";
    import TutorialEntity from "../../../../../js/components/atoms/Entities/TutorialEntity";
    import ProjectEntity from "../../../../../js/components/atoms/Entities/ProjectEntity";
    import TutorialTable from "../../../../../js/components/organisms/TutorialTable";
    import BModal from "buefy/src/components/modal/Modal";

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
        name: 'TutorialsTemplate',
        components: {
            BModal,
            TutorialTable,
            ValidationObserver,
            ProjectNotFoundModal,
            Message,
            LoadingModal,
            DriverEditor,
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
            query: {
                type: String,
                default: null,
            },
            pagination: {
                type: Object,
                default() {
                    return {}
                }
            },
            total: {
                type: Number,
                default: 0,
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
            },
            showProjectNotFoundModal: {
                type: Boolean,
                default: false,
            },
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
            width: 90% !important;
        }
    }
</style>