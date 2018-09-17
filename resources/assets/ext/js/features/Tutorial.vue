<template>
    <div>
        <Menu
            v-show="userAction === 'onMenu'"
            class="tutorial-panel"
            :class="{'is-fixed-bottom-right': menuIsOnTheRight, 'is-fixed-bottom-left': !menuIsOnTheRight }"
            :tutorials="tutorials"
            :selected-tutorial="selectedTutorial"
            :selected-step="selectedStep"
            @homeClick="$emit('homeClick')"
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

        <Setting
            v-show="userAction === 'editingTutorial' | userAction === 'addingTutorial'"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateUserAction('onMenu')"
            :tutorial="userAction === 'editingTutorial' ? selectedTutorial : null"
        >
        </Setting>

        <BaseMessage
            v-show="message.isShown"
            :dont-show-me-option="message.dontShowMeOption"
            :dontShowMeChecked="message.dontShowMeChecked"
            :header="message.header"
            :body="message.body"
            :message-classes="message.messageClasses"
            @closeClick="hideMessage"
            @dontShowMeChecked="e => message.dontShowMeChecked = e"
        ></BaseMessage>
    </div>
</template>
<script>
import uuidv4 from 'uuid/v4'
import finder from '@medv/finder'
import {
    mapActions,
    mapGetters,
    mapState,
} from 'vuex'
import Driver from '../../driver.js/src'
import BaseMessage from '../components/BaseMessage'
import Menu from '../components/Tutorial/Menu'
import Setting from '../components/Tutorial/Setting'
import DeleteConfirmationMessage from "../components/Tutorial/DeleteConfirmationMessage";

import purify from 'dompurify'

const messageKeys = {
    clickToAddStep: 'clickToAddStep',
    selectorChoicesAvailable: 'selectorChoicesAvailable',
    noStepAddedYet: 'noStepAddedYet',
    noMoreSelectorChoices: 'noMoreSelectorChoices',
}

const userActions = {
    onMenu: 'onMenu',
    addingStep: 'addingStep',
    addingTutorial: 'addingTutorial',
    editingTutorial: 'editingTutorial',
    deletingTutorial: 'deletingTutorial',
    editingPopover: 'editingPopover',
    previewing: 'previewing',
    usingAdvancedEditor: 'usingAdvancedEditor',
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
            userAction: userActions.onMenu,
            driver: null,
            message: {
                key: '',
                dontShowMeOption: true,
                dontShowMeChecked: false,
                header: '',
                body: '',
                messageClasses: [],
                isShown: false,
            },
            menuIsOnTheRight: true,
            selectorChoices: [],
            selectorChoiceIndex: 0,
            maxRetries: 5,
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
            'addStep',
            'updateStep',
            'deleteStep'
        ]),
        ...mapActions([
            'retrieveLog',
            'saveLog'
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
        showMessage({ key, header, body, messageClasses }) {
            if (!this.extLog.checkedMessages || !this.extLog.checkedMessages.includes(key)) {
                this.message = {
                    ...this.message,
                    key,
                    header,
                    body,
                    messageClasses,
                    isShown: true,
                }
            }
        },
        hideMessage() {
            this.message.isShown = false
            this.message.dontShowMeChecked = false
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
        extractSelectorChoices(e) {
            let upperElements = []
            let lowerElements = []
            e.composedPath().find((el, index) => {
                if (el.tagName.toLowerCase() === 'body') return true
                const selector = this.getSelector(el)
                upperElements.push(selector)
                if (index === 0) {
                    Array.from(el.children).forEach((childEl) => {
                        const selector = this.getSelector(childEl)
                        lowerElements.push(selector)
                    })
                }
                return false
            })

            return [
                ...lowerElements,
                ...upperElements,
            ]
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
                    this.selectorChoices = this.extractSelectorChoices(e)
                }

                const selector = this.selectorChoices[this.selectorChoiceIndex]
                this.highlight({
                    element: selector,
                })

                this.showMessage({
                    key: messageKeys.selectorChoicesAvailable,
                    header: "Tips",
                    body: "If the element is not correctly highlighted or not bright enough, you should keep clicking until you find the right one.",
                    messageClasses: ['is-info', 'is-fixed-top-right'],
                })
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

            console.log(element);

            this.driver.highlight({
                element,
                popover,
            })

            this.selectorChoiceIndex += 1
        },
        onPreviewClick() {
            if (this.selectedTutorial.steps.length === 0) {
                this.showMessage({
                    key: this.messageKeys.noStepAddedYet,
                    header: "Oops",
                    body: "You haven't added any step yet.",
                    messageClasses: ['is-warning', 'is-fixed-top-right'],
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
                    key: messageKeys.noMoreSelectorChoices,
                    header: "Oops",
                    body: "Looks like we don't have any other elements to show you.",
                    messageClasses: ['is-warning', 'is-fixed-top-right'],
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
                        key: messageKeys.clickToAddStep,
                        header: "Tips",
                        body: "Click anywhere you want to attract your user attention",
                        messageClasses: ['is-info', 'is-small', 'is-fixed-top-right'],
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
        message: {
            deep: true,
            handler(newValue, oldValue) {
                if (!newValue.isShown) {
                    if (oldValue.dontShowMeChecked) {
                        this.saveLog({
                            checkedMessages: [
                                ...this.extLog.checkedMessages,
                                oldValue.key,
                            ]
                        })
                    }
                }
            },
        }
    },
    computed: {
        ...mapState('tutorial', {
            tutorials: state => state.tutorials,
            selectedTutorialId: state => state.selectedTutorialId,
            selectedStepId: state => state.selectedStepId,
        }),
        ...mapState(['extLog']),
        ...mapGetters('tutorial', [
            'selectedTutorial',
            'selectedStep',
        ]),
    },
    components: {
        DeleteConfirmationMessage,
        BaseMessage,
        Menu,
        Setting,
    },
}
</script>
<style scoped>
    .tutorial-panel {
        min-width: 30vw;
        max-width: 30vw;
        width: 30vw;
        z-index: 10000000;
    }
    .editing-actions {
        height: 50px;
        z-index: 100000000;
    }
</style>