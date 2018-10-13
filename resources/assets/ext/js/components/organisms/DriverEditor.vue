<template>
    <div class="step-editing-actions has-padding-4 is-fixed-bottom-right">
        <BaseButton
            id="om-adding-step-save"
            @click="onSaveClick"
            is-success
        >
            Save
        </BaseButton>
        <BaseButton
            id="om-adding-step-cancel"
            @click="onCancelClick"
        >
            Cancel
        </BaseButton>
    </div>
</template>

<script>
    import finder from '@medv/finder'
    import purify from 'dompurify'
    import Driver from '../../../../../../../driver.js/src/index'
    import BaseButton from '../atoms/BaseButton'

    export const userActions = {
        creatingPopover: 'creatingPopover',
        creatingHighlight: 'creatingHighlight',
        editingPopover: 'editingPopover',
        // selectingHighlight: 'selectingHighlight',
    }

    export default {
        name: "DriverEditor",
        created() {
            document.querySelectorAll( 'body *' ).forEach(el => {
                el.addEventListener('click', this.userScreenClickHandler)
            })

            this.driver = new Driver({
                animate: false,
            })
        },
        destroyed() {
            this.driver = null
            document.querySelectorAll( 'body *' ).forEach(el => {
                el.removeEventListener('click', this.userScreenClickHandler)
            })
        },
        props: {
            tutorial: {
                type: Object,
                default: null,
            },
            stepId: {
                type: String,
                default: null,
            },
        },
        data() {
            return {
                driver: null,
                userAction: userActions.creatingHighlight,
                selectorChoices: [],
                selectorChoiceIndex: 0,
                maxRetries: 5,
            }
        },
        computed: {
            step() {
                return this.tutorial && this.stepId ? this.tutorial.steps.find(step => step.id === this.stepId) : null
            },
            isCreatingPopover() {
                return this.userAction === userActions.creatingPopover
            },
            isCreatingHighlight() {
                return this.userAction === userActions.creatingHighlight
            },
            isEditingPopover() {
                return this.userAction === userActions.editingPopover
            },
            // isSelectingHighlight() {
            //     return this.userAction === userActions.selectingHighlight
            // },
        },
        watch: {
        },
        methods: {
            updateUserAction(userAction = null) {
                if (Object.values(userActions).includes(userAction)) {
                    this.userAction = userAction
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
            onCancelClick() {
                this.$emit('cancelClick')
                this.updateUserAction(userActions.creatingHighlight)
            },
            onSaveClick() {
                const activeElement = this.driver.getHighlightedElement()
                const step = this.createStep(activeElement)
                this.$emit('saveClick', step)
                this.updateUserAction(userActions.creatingHighlight)
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
                e.preventDefault() // for driver.js
                e.stopPropagation() // for driver.js
                if (this.isCreatingPopover) {
                    if (e.target.id === 'om-adding-step-cancel' || e.target.id === 'om-adding-step-save') return
                    if (this.selectorChoices.length > 0) {
                        this.showAnotherChoice()
                    }
                } else if (this.isCreatingHighlight) {
                    if (this.selectorChoices.length === 0) {
                        this.selectorChoices = this.extractSelectorChoices(e)
                    }

                    const selector = this.selectorChoices[this.selectorChoiceIndex]
                    this.highlight({
                        element: selector,
                    })

                    // this.showMessage(messageKeys.selectorChoicesAvailable)
                }
            },
            highlight({ id=null, element, popover={ content: '<div><h1>Title</h1><div>Some description here</div></div>' } }) {
                // If there is a step with the same selector, we use it again.
                if (id) {
                    const step = this.tutorial.steps.find(s => s.element === element)
                    if (step) {
                        this.$emit('sameElementSelect', step)
                        return
                    }
                }
                this.driver.options.allowClose = false
                this.driver.options.isEditMode = true

                const userAction = id ? userActions.editingPopover : userActions.creatingPopover
                this.updateUserAction(userAction)

                this.driver.highlight({
                    element,
                    popover,
                })

                if (this.isCreatingPopover) {
                    this.selectorChoiceIndex += 1
                }
            },
            preview() {
                this.driver.options.allowClose = true
                this.driver.options.onReset = () => this.$emit('reset')
                this.driver.defineSteps(this.tutorial.steps)
                this.driver.start()
            },
            showAnotherChoice() {
                if (!this.isCreatingPopover) return
                if (this.selectorChoiceIndex === (this.selectorChoices.length - 1) || (this.selectorChoiceIndex + 1) > this.maxRetries ) {
                    // this.showMessage(messageKeys.noMoreSelectorChoices)
                    this.selectorChoiceIndex = 0
                } else {
                    this.highlight({
                        element: this.selectorChoices[this.selectorChoiceIndex]
                    })
                }
            }
        },
        components: {
            BaseButton,
        }
    }
</script>