<template>
    <div>
        <div
            class="primary-nav"
            v-show="userAction === 'home'"
        >
            <div class="has-background-dark"></div>
            <nav class="navbar level has-background-dark has-margin-bottom-0 has-padding-4 is-fixed-bottom">
                <div class="level-left">
                    <h1 class="has-text-white is-size-4">Omotenashi</h1>
                </div>
                <div class="level-right">
                    <p class="level-item">
                        <button
                            class="button is-success"
                            @click.stop.prevent="updateUserAction('onMenu')"
                        >
                            {{ extLog.userIsFirstTime ? 'Get started' : 'Tutorial' }}
                        </button>
                    </p>
                    <p class="level-item">
                        <a class="button" href="#">
                            Feedback
                        </a>
                    </p>
                </div>
            </nav>
        </div>

        <Menu
            v-show="userAction === 'onMenu'"
            class="tutorial-panel"
            :class="{'is-fixed-bottom-right': isRight, 'is-fixed-bottom-left': !isRight }"
            :tutorials="tutorials"
            :selected-tutorial="selectedTutorial"
            :selected-step="selectedStep"
            @homeClick="updateUserAction('home')"
            @previewClick="onPreviewClick"
            @addStepClick="() => {
                updateUserAction('addingStep')
                selectStep(null)
            }"
            @stepClick="editStep"
            @deleteStepClick="deleteStep"
            @addTutorialClick="updateUserAction('addingTutorial')"
            @editTutorialClick="updateUserAction('editingTutorial')"
            @deleteTutorialClick="updateUserAction('deletingTutorial')"
            @switchSideClick="isRight = !isRight"
        ></Menu>

        <BaseMessage
            v-show="userAction === 'deletingTutorial'"
            header="Delete Tutorial"
            :message-class="['is-danger', 'is-fixed-bottom-right']"
            @closeClick="updateUserAction('onMenu')"
        >
            <p class="has-padding-top-1 has-padding-bottom-4">
                Your are about to delete "{{ selectedTutorial.name }}".<br/>
                Please type in the name of the tutorial to confirm.
            </p>
            <div class="field">
                <p class="control">
                    <input
                        class="input"
                        type="text"
                        placeholder="Tutorial name"
                        v-model="tutorialNameToDelete"
                    >
                </p>
            </div>
            <div class="field">
                <button
                    class="button is-danger is-outlined is-fullwidth"
                    :disabled="tutorialNameToDelete === '' || tutorialNameToDelete != selectedTutorial.name"
                    @click="() => {
                        deleteTutorial(selectedTutorial)
                        updateUserAction('onMenu')
                    }"
                >
                    DELETE
                </button>
            </div>
        </BaseMessage>

        <div
            class="editing-actions has-padding-4 is-fixed-bottom-right"
            v-show="userAction === 'editingPopover'"
        >
            <button
                class="button is-success"
                @click="onStepSaveClick"
            >
                Save
            </button>
            <button
                class="button"
                @click="updateUserAction('onMenu')"
            >
                Cancel
            </button>
        </div>

        <GreetingModal
            v-show="extLog.userIsFirstTime"
            @startClick="() => {
                updateUserAction('onMenu');
            }"
        ></GreetingModal>

        <Editor
            id="advanced-editor"
            :quill-contents="titleQuillContents"
            v-show="userAction === 'usingAdvancedEditor'"
            @doneClick="onAdvancedEditingDoneClick"
        >
        </Editor>

        <Setting
            v-show="userAction === 'editingTutorial' | userAction === 'addingTutorial'"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateUserAction('onMenu')"
            :tutorial="userAction === 'editingTutorial' ? selectedTutorial : null"
        >
        </Setting>

        <BaseMessage
            v-show="message.isShown"
            :header="message.header"
            :body="message.body"
            :message-class="message.messageClass"
            @closeClick="hideMessage"
        ></BaseMessage>
    </div>
</template>
<script>
import uuidv4 from 'uuid/v4';
import finder from '@medv/finder';
import Driver from 'driver.js/dist/driver.min.js';
import {
    mapState,
    mapActions,
    mapGetters,
} from 'vuex';

import BaseMessage from '../components/BaseMessage'
import GreetingModal from '../components/Tutorial/GreetingModal'
import Editor from '../components/Tutorial/Editor'
import Menu from '../components/Tutorial/Menu'
import Setting from '../components/Tutorial/Setting'

const userActions = {
    onMenu: 'onMenu',
    addingStep: 'addingStep',
    addingTutorial: 'addingTutorial',
    editingTutorial: 'editingTutorial',
    deletingTutorial: 'deletingTutorial',
    editingPopover: 'editingPopover',
    previewing: 'previewing',
    usingAdvancedEditor: 'usingAdvancedEditor',
    home: 'home',
}

export default {
    created() {
        document.body.addEventListener('click', this.onUserScreenClick)
        this.driver = new Driver()

        this.retrieveLog()

        if (this.tutorials.length == 0) {
            this.addTutorial({
                id: uuidv4(),
                name: 'Your first Tutorial',
                steps: [],
            })
        }
    },
    beforeDestroy() {
        this.driver = null
    },
    data() {
        return {
            userAction: userActions.home,
            driver: null,
            message: {
                header: '',
                body: '',
                messageClass: [],
                isShown: false,
            },
            isRight: true,
            tutorialNameToDelete: '',
            // editorOpenButton: '<span id="open-advanced-editor-button" contenteditable="false" style="user-select: none; position: absolute; right:0; bottom:0; font-size: 11px; color: #3273dc;">advanced editor</span>',
            titleQuillContents: null,
        }
    },
    methods: {
        ...mapActions('tutorial', [
            'addTutorial',
            'updateTutorial',
            'deleteTutorial',
            'selectTutorial',
            'selectStep',
            'retrieveLog',
            'saveLog',
            'addStep',
            'updateStep',
            'deleteStep'
        ]),
        updateUserAction(state = null) {
            if (!Object.values(userActions).includes(state)) return
            this.userAction = state
        },
        getSelector(node) {
            if (!node) return
            return finder(node, {
                root: document.body,
                id: name => !name.includes('driver-'),
                className: name => !name.includes('driver-'),
                tagName: () => true,
                seedMinLength: 5,
                optimizedMinLength: 4,
                threshold: 1000
            })
        },
        showMessage({ header, body, messageClass }) {
            this.message = {
                header,
                body,
                messageClass,
                isShown: true,
            }
        },
        hideMessage() {
            this.message.isShown = false
        },
        onTutorialSaveClick(tutorial) {
            if (tutorial.id) {
                this.updateTutorial(tutorial)
            } else {
                this.addTutorial({
                    id: uuidv4(),
                    steps: [],
                    ...tutorial,
                })
            }
            this.updateUserAction(userActions.onMenu)
        },
        editStep(step) {
            this.selectStep(step.id)
            this.updateUserAction(userActions.editingPopover)

            this.driver.highlight({
                element: step.element,
                popover: step.popover,
            })
        },
        onAdvancedEditingClick() {
            this.updateUserAction('usingAdvancedEditor')
        },
        onStepSaveClick() {
            const activeElement = this.driver.getHighlightedElement()
            const popover = activeElement.getPopover()
            const title = popover.getTitleNode().innerHTML
            const description = popover.getDescriptionNode().innerHTML

            const activeNode = activeElement.getNode()
            const selector = this.getSelector(activeNode)

            if (this.selectedStepId) {
                this.updateStep({
                    id: this.selectedStepId,
                    element: selector,
                    popover: {
                        title: title,
                        description: description,
                    },
                })
            } else {
                this.addStep({
                    id: uuidv4(),
                    element: selector,
                    popover: {
                        title: title,
                        description: description,
                    },
                })
            }
            this.updateUserAction(userActions.onMenu)
        },
        onUserScreenClick(e) {
            // if (e.target.id === 'open-advanced-editor-button') {
            //     this.onAdvancedEditingClick()
            // }
            if (e.composedPath().find(el => el.id === 'omotenashi')) return
            if (this.userAction === userActions.addingStep) {
                e.stopPropagation() // for driver.js
                e.preventDefault() // for driver.js
                if (this.userAction === userActions.addingStep) {
                    this.updateUserAction(userActions.editingPopover)

                    const selector = this.getSelector(e.target)

                    // If there is a step with the same selector, we use it again.
                    const step = this.selectedTutorial.steps.find(s => s.element === selector)
                    if (step) {
                        this.editStep(step)
                    } else {
                        this.driver.highlight({
                            element: selector,
                            popover: {
                                // title: 'Edit me!'+this.editorOpenButton,
                                title: 'Edit me!',
                                description: 'Some description here',
                            },
                        })
                    }
                }
            }
        },
        onPreviewClick() {
            if (this.selectedTutorial.steps.length === 0) {
                this.showMessage({
                    header: "Oops",
                    body: "You haven't added any step yet.",
                    messageClass: ['is-warning', 'is-small', 'is-fixed-top-right'],
                })
                return
            }
            this.updateUserAction(userActions.previewing)
        },
        onAdvancedEditingDoneClick({ html, quillContents }) {
            // document.querySelector('.driver-popover-title').innerHTML = html + this.editorOpenButton,
            // this.titleQuillContents = quillContents
            this.updateUserAction(userActions.editingPopover)
        }
    },
    watch: {
        userAction(newValue, oldValue) {
            switch (newValue) {
                case userActions.onMenu:
                    if (this.extLog.userIsFirstTime) {
                        this.saveLog({userIsFirstTime: false})
                    }

                    if (oldValue === userActions.previewing) {
                        this.driver.options.allowClose = false
                        this.driver.options.onReset = () => {}
                    }

                    if (oldValue === userActions.editingPopover) {
                        this.driver.reset()
                    }

                    if (oldValue === userActions.deletingTutorial) {
                        this.tutorialNameToDelete = ''
                    }

                    break
                case userActions.addingStep:
                    this.showMessage({
                        header: "Tips",
                        body: "Click anywhere you want to attract your user attention",
                        messageClass: ['is-info', 'is-small', 'is-fixed-top-right'],
                    })
                    break
                case userActions.previewing:
                    this.driver.options.allowClose = true
                    this.driver.options.onReset = (e) => {
                        this.updateUserAction(userActions.onMenu)
                    }
                    this.driver.defineSteps(this.selectedTutorial.steps)
                    this.driver.start()

                    document.querySelector('.driver-popover-title').removeAttribute('contenteditable')
                    document.querySelector('.driver-popover-description').removeAttribute('contenteditable')
                    break
                case userActions.editingPopover:
                    const titleEl = document.querySelector('.driver-popover-title')
                    const descEl = document.querySelector('.driver-popover-description')
                    titleEl.setAttribute('contenteditable', true)
                    descEl.setAttribute('contenteditable', true)
                    this.driver.options.allowClose = false
                    break
                default:
            }
        }
    },
    computed: {
        ...mapState('tutorial', {
            tutorials: state => state.tutorials,
            selectedTutorialId: state => state.selectedTutorialId,
            selectedStepId: state => state.selectedStepId,
            extLog: state => state.extLog,
        }),
        ...mapGetters('tutorial', [
            'selectedTutorial',
            'selectedStep',
        ]),
    },
    components: {
        BaseMessage,
        Editor,
        GreetingModal,
        Menu,
        Setting,
    },
}
</script>
<style scoped>
    .primary-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .tutorial-panel {
        min-width: 30vw;
    }

    .editing-actions {
        height: 50px;
        z-index: 100000000;
    }

    #advanced-editor {
        z-index: 10000000000;
    }

</style>