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
            :class="{'is-fixed-bottom-right': menuIsOnTheRight, 'is-fixed-bottom-left': !menuIsOnTheRight }"
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
            @switchSideClick="menuIsOnTheRight = !menuIsOnTheRight"
        ></Menu>

        <DeleteConfirmationMessage
                v-show="userAction === 'deletingTutorial'"
                :selected-tutorial="selectedTutorial"
                @closeClick="updateUserAction('onMenu')"
                @deleteClick="() => {
                    deleteTutorial(selectedTutorial)
                }"
        >
        </DeleteConfirmationMessage>

        <div
            class="editing-actions has-padding-4 is-fixed-bottom-right"
            v-show="userAction === 'editingPopover'"
        >
            <button
                id="om-adding-step-save"
                class="button is-success"
                @click="onStepSaveClick"
            >
                Save
            </button>
            <button
                id="om-adding-step-cancel"
                class="button"
                @click="updateUserAction('onMenu')"
            >
                Cancel
            </button>
        </div>

        <GreetingModal
            v-show="extLog.userIsFirstTime"
            @startClick="updateUserAction('onMenu')"
        ></GreetingModal>

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
import uuidv4 from 'uuid/v4'
import finder from '@medv/finder'
// import Driver from 'driver.js/dist/driver.min.js';
import Driver from '../../driver.js/src/index'
import {mapActions, mapGetters, mapState,} from 'vuex'

import BaseMessage from '../components/BaseMessage'
import GreetingModal from '../components/Tutorial/GreetingModal'
import Editor from '../components/Tutorial/Editor'
import Menu from '../components/Tutorial/Menu'
import Setting from '../components/Tutorial/Setting'
import DeleteConfirmationMessage from "../components/Tutorial/DeleteConfirmationMessage";

import purify from 'dompurify'

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
        document.querySelectorAll( 'body *' ).forEach(el => {
            el.addEventListener('click', this.userScreenClickHandler)
        })

        this.driver = new Driver({
            animate: false,
        })

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
        document.querySelectorAll( 'body *' ).forEach(el => {
            el.removeEventListener('click', this.userScreenClickHandler)
        })
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
            menuIsOnTheRight: true,
            selectorChoices: [],
            selectorChoiceIndex: 0,
            maxRetries: 3,
            editor: null,
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
            if (Object.values(userActions).includes(state)) {
                this.userAction = state
            }
        },
        getSelector(node) {
            if (node) {
                return finder(node, {
                    root: document.body,
                    id: name => !name.includes('driver-'),
                    className: name => !name.includes('driver-'),
                    tagName: () => true,
                    seedMinLength: 5,
                    optimizedMinLength: 4,
                    threshold: 1000
                })
            }
            return null
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
            console.log(step)
            this.selectStep(step.id)
            this.highlight(step)
        },
        createStep(element) {
            const popover = element.getPopover()
            const content = purify.sanitize(popover.getContentNode().input)

            const activeNode = element.getNode()
            const selector = this.getSelector(activeNode)
            return {
                element: selector,
                popover: {
                    content: content,
                },
            }
        },
        onStepSaveClick() {
            const activeElement = this.driver.getHighlightedElement()
            const { element, popover } = this.createStep(activeElement)

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
            this.updateUserAction(userActions.onMenu)
        },
        userScreenClickHandler(e) {
            // omotenashiの要素のクリックは無視
            if (e.composedPath().find(el => el.id === 'omotenashi')) return
            if (this.userAction === userActions.editingPopover) {
                if (e.target.id === 'om-adding-step-cancel' || e.target.id === 'om-adding-step-save') return
                e.stopPropagation()
                e.preventDefault()
                if (this.selectorChoices.length > 0) {
                    this.showAnotherChoice()
                }
            } else if (this.userAction === userActions.addingStep) {
                e.preventDefault() // for driver.js
                e.stopPropagation() // for driver.js
                if (this.selectorChoices.length === 0) {
                    e.composedPath().find(el => {
                        if (el === document.documentElement) return true
                        this.selectorChoices.push(el)
                        return false
                    })
                }

                const selector = this.selectorChoices[this.selectorChoiceIndex]
                this.highlight({
                    element: selector,
                })

                this.showMessage({
                    header: "Tips",
                    body: "If the element is not correctly highlighted, you should keep clicking until you find the right one.",
                    messageClass: ['is-info', 'is-fixed-top-right'],
                })
            } else {
            }
        },
        highlight({ id=null, element, popover={ content: '<div><h1>Title</h1><div>Some description here</div></div>' } }) {
            // If there is a step with the same selector, we use it again.
            if (!id) {
                const step = this.selectedTutorial.steps.find(s => s.element === element)
                if (step) {
                    this.selectStep(step.id)
                }
            }
            this.driver.options.allowClose = false
            this.driver.options.isEditMode = true
            this.updateUserAction(userActions.editingPopover)

            this.driver.highlight({
                element,
                popover,
            })

            this.selectorChoiceIndex += 1
        },
        onPreviewClick() {
            if (this.selectedTutorial.steps.length === 0) {
                this.showMessage({
                    header: "Oops",
                    body: "You haven't added any step yet.",
                    messageClass: ['is-warning', 'is-fixed-top-right'],
                })
                return
            }
            this.updateUserAction(userActions.previewing)
            this.preview()
        },
        preview() {
            this.driver.options.allowClose = true
            this.driver.options.onReset = (e) => {
                this.updateUserAction(userActions.onMenu)
            }
            this.driver.defineSteps(this.selectedTutorial.steps)
            this.driver.start()
        },
        showAnotherChoice() {
            if (this.selectorChoiceIndex === (this.selectorChoices.length - 1) || (this.selectorChoiceIndex + 1) > this.maxRetries ) {
                this.showMessage({
                    header: "Oops",
                    body: "Looks like we don't have any other elements to show you.",
                    messageClass: ['is-warning', 'is-fixed-top-right'],
                })
                this.selectorChoiceIndex = 0
            } else {
                this.highlight({
                    element: this.selectorChoices[this.selectorChoiceIndex]
                })
            }
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
                        this.driver.options.isEditMode = false

                        this.selectorChoices = []
                        this.selectorChoiceIndex = 0
                    }
                    break
                case userActions.addingStep:
                    this.showMessage({
                        header: "Tips",
                        body: "Click anywhere you want to attract your user attention",
                        messageClass: ['is-info', 'is-small', 'is-fixed-top-right'],
                    })
                    break
                default:
            }
        },
        tutorials(newValue, oldValue) {
            if ((oldValue.length - newValue.length) === 1) {
                this.updateUserAction('onMenu')
            }
        },
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
        DeleteConfirmationMessage,
        BaseMessage,
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
        max-width: 30vw;
        width: 30vw;
    }
    .primary-nav,
    .tutorial-panel {
        z-index: 10000000;
    }

    .editing-actions {
        height: 50px;
        z-index: 100000000;
    }
</style>