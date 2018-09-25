<template>
    <div>
        <Menu
            v-show="isOnMenu"
            class="tutorial-panel"
            :class="{'is-fixed-bottom-right': menuIsOnTheRight, 'is-fixed-bottom-left': !menuIsOnTheRight }"
            :tutorials="tutorials"
            :selected-tutorial="selectedTutorial"
            :selected-step="selectedStep"
            @tutorialChange="selectTutorial"
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
            v-show="isDeletingTutorial"
            :tutorial="selectedTutorial"
            @closeClick="updateUserAction('onMenu')"
            @deleteClick="deleteTutorial(selectedTutorial)"
        >
        </DeleteConfirmationMessage>

        <div
            class="step-editing-actions has-padding-4 is-fixed-bottom-right"
            v-show="isEditingPopover"
        >
            <BaseButton
                id="om-adding-step-save"
                @click="onStepSaveClick"
                is-success
            >
                Save
            </BaseButton>
            <BaseButton
                id="om-adding-step-cancel"
                @click="updateUserAction('onMenu')"
            >
                Cancel
            </BaseButton>
        </div>

        <Setting
            v-show="isEditingTutorial || isAddingTutorial"
            @saveClick="onTutorialSaveClick"
            @cancelClick="updateUserAction('onMenu')"
            :tutorial="isEditingTutorial ? selectedTutorial : null"
        >
        </Setting>

        <HelpMessage
            v-show="selectorChoicesAvailableMessageShown"
            :has-dont-show-me-option="true"
            :dont-show-me="dontShowMeChecked('selectorChoicesAvailable')"
            is-info
            @closeClick="hideMessage"
            @dontShowMeChenge="removeMessage"
        >
            <template slot="head">Tips</template>
            <template slot="body">
                If the element is not correctly highlighted,<br>
                please keep clicking until you find the right one.
            </template>
        </HelpMessage>

        <HelpMessage
            v-show="noStepAddedYetMessageShown"
            is-warning
            @closeClick="hideMessage"
        >
            <template slot="head">Oops</template>
            <template slot="body">
                You haven't added any step yet.
            </template>
        </HelpMessage>

        <HelpMessage
            v-show="noMoreSelectorChoicesMessageShown"
            is-warning
            @closeClick="hideMessage"
        >
            <template slot="head">Oops</template>
            <template slot="body">
                Looks like we don't have any other elements to show you.
            </template>
        </HelpMessage>

        <HelpMessage
            v-show="clickToAddStepMessageShown"
            :has-dont-show-me-option="true"
            :dont-show-me="dontShowMeChecked('clickToAddStep')"
            is-info
            @closeClick="hideMessage"
            @dontShowMeChenge="removeMessage"
        >
            <template slot="head">Tips</template>
            <template slot="body">
                Click anywhere you want to attract your user attention.
            </template>
        </HelpMessage>
    </div>
</template>
<script>
    import uuidv4 from 'uuid/v4'
    import finder from '@medv/finder'
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import Driver from '../../driver.js/src'
    import HelpMessage from '../components/Tutorial/HelpMessage'
    import Menu from '../components/Tutorial/Menu'
    import Setting from '../components/Tutorial/Setting'
    import DeleteConfirmationMessage from "../components/Tutorial/DeleteConfirmationMessage";

    import purify from 'dompurify'
    import BaseButton from "../components/BaseButton";

    export const messageKeys = {
        clickToAddStep: 'clickToAddStep',
        selectorChoicesAvailable: 'selectorChoicesAvailable',
        noStepAddedYet: 'noStepAddedYet',
        noMoreSelectorChoices: 'noMoreSelectorChoices',
    }

    export const userActions = {
        onMenu: 'onMenu',
        addingStep: 'addingStep',
        addingTutorial: 'addingTutorial',
        editingTutorial: 'editingTutorial',
        deletingTutorial: 'deletingTutorial',
        editingPopover: 'editingPopover',
        previewing: 'previewing',
    }

    export default {
        created() {
            document.querySelectorAll( 'body *' ).forEach(el => {
                el.addEventListener('click', this.userScreenClickHandler)
            })

            this.driver = new Driver({
                animate: false,
            })

            if (this.tutorials.length == 0) {
                this.addTutorial({
                    id: uuidv4(),
                    name: 'Your first Tutorial',
                    steps: [],
                })
            }
        },
        destroyed() {
            this.driver = null
            document.querySelectorAll( 'body *' ).forEach(el => {
                el.removeEventListener('click', this.userScreenClickHandler)
            })
        },
        data() {
            return {
                userAction: userActions.onMenu,
                messageShown: null,
                driver: null,
                menuIsOnTheRight: true,
                selectorChoices: [],
                selectorChoiceIndex: 0,
                maxRetries: 5,
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

                    this.showMessage(messageKeys.selectorChoicesAvailable)
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
                    this.showMessage(messageKeys.noStepAddedYet)
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
                    this.showMessage(messageKeys.noMoreSelectorChoices)
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
                        this.showMessage(messageKeys.clickToAddStep)
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
            }),
            ...mapState(['extLog']),
            ...mapGetters('tutorial', [
                'selectedTutorial',
                'selectedStep',
            ]),
            isOnMenu() {
                return (this.userAction === userActions.onMenu)
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
            clickToAddStepMessageShown() {
                return (this.messageShown === messageKeys.clickToAddStep)
            },
        },
        components: {
            BaseButton,
            DeleteConfirmationMessage,
            HelpMessage,
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
    .step-editing-actions {
        height: 50px;
        z-index: 100000000;
    }
</style>