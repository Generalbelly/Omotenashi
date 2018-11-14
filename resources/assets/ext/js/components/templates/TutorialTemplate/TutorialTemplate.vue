<template>
    <div>
        <Menu
            v-show="isHome"
            class="menu"
            :class="{
                'is-fixed-bottom-right': menuIsOnTheRight,
                'is-fixed-bottom-left': !menuIsOnTheRight,
            }"
            :is-loading="isRequesting === 'REQUEST_GET_TUTORIALS'"
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
            @closeClick="updateState('beingHome')"
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
            @cancelClick="updateState('beingHome')"
            @previewDone="updateState('beingHome')"
            @editDone="updateState('beingHome')"
            @dontShowMeChange="removeMessage"
        >
        </DriverEditor>

        <Setting
            v-show="isEditingTutorial || isAddingTutorial"
            :tutorial="isEditingTutorial ? selectedTutorial : null"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateState('beingHome')"
        >
        </Setting>

        <Message
            v-show="showUrlChangeAlert"
            is-warning
            @closeClick="showUrlChangeAlert = false"
        >
            <template slot="header">Alert</template>
            <template slot="body">
                URL might've changed.
            </template>
        </Message>

        <LoadingModal
            v-show="isRequesting && isRequesting !== 'REQUEST_GET_TUTORIALS'"
        ></LoadingModal>
    </div>
</template>
<script>
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import LoadingModal from '../../../../../js/components/molecules/LoadingModal'
    import Menu from '../../organisms/Menu'
    import Setting from '../../organisms/Setting'
    import DeleteConfirmationMessage from "../../organisms/DeleteConfirmationMessage"
    import DriverEditor from "../../organisms/DriverEditor"
    import Message from "../../../../../js/components/molecules/Message";

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
                type: [Boolean, String],
                default: false,
            },
            extLog: {
                type: Object,
                default() {
                    return {};
                },
            },
            domain: {
                type: String,
                default: null,
            }
        },
        components: {
            Message,
            LoadingModal,
            DriverEditor,
            DeleteConfirmationMessage,
            Menu,
            Setting,
        },
        data() {
            return {
                state: states.beingHome,
                messageShown: null,
                menuIsOnTheRight: true,
                showUrlChangeAlert: false,
            }
        },
        mounted() {
            const self = this;
            const proxiedOpen = XMLHttpRequest.prototype.open
            window.XMLHttpRequest.prototype.open = function (method, url) {
                this._url = url;
                return proxiedOpen.apply(this, arguments);
            };

            const proxiedSend = window.XMLHttpRequest.prototype.send
            window.XMLHttpRequest.prototype.send = function() {
                // https://stackoverflow.com/questions/10783463/javascript-detect-ajax-requests
                if (this._url.includes(self.domain) && self.selectedTutorial) {
                    if (this._url !== self.selectedTutorial.url) {
                        self.showUrlChangeAlert = true
                    }
                }
                return proxiedSend.apply(this, [].slice.call(arguments))
            }
        },
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog'
            ]),
            showTutorialUrlChangeAlert() {
                return new Promise(resolve => {
                    this.$refs.tutorialUrlChangeAlert.subscribe('confirm', () => {
                        resolve(true);
                    })
                    this.$refs.tutorialUrlChangeAlert.subscribe('cancel', () => {
                        resolve(false);
                    })
                })
            },
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
                this.updateState(states.addingStep)
            },
            onAddTutorialClick() {
                this.updateState(states.addingTutorial)
            },
            onDeleteTutorialClick() {
                this.updateState(states.deletingTutorial)
            },
            onDeleteConfirmTutorialClick(id) {
                this.$emit('deleteTutorialConfirmClick', { id })
                this.updateState(states.deletingTutorial)
            },
            onTutorialSaveClick(tutorial) {
                this.$emit('tutorialSaveClick', tutorial)
                this.updateState(states.beingHome)
            },
            onEditTutorialClick() {
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
            tutorials(newValue, oldValue) {
                if ((oldValue.length - newValue.length) === 1) {
                    this.updateState('beingHome')
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