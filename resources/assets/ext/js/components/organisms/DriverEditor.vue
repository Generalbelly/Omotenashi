<template>
    <div
        v-show="isSelectingHighlight"
        class="has-padding-4 is-fixed-bottom-right"
    >
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
        creatingHighlight: 'creatingHighlight',
        selectingHighlight: 'selectingHighlight',
        previewing: 'previewing',
        editingPopover: 'editingPopover',
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
            isHighlightSelectionActive: {
                type: Boolean,
                default: false,
            },
            steps: {
                type: Array,
                default() {
                    return []
                },
            },
        },
        data() {
            return {
                driver: null,
                userAction: null,
                selectorChoices: [],
                selectorChoiceIndex: 0,
                maxRetries: 5,
                step: null,
            }
        },
        computed: {
            isCreatingHighlight() {
                return this.userAction === userActions.creatingHighlight
            },
            isSelectingHighlight() {
                return this.userAction === userActions.selectingHighlight
            },
        },
        watch: {
            userAction(newValue, oldValue) {
                if (newValue === userActions.creatingHighlight && oldValue != null){
                    this.$emit('done')
                }

                if (oldValue === userActions.selectingHighlight) {
                    this.driver.reset()
                    this.driver.options.allowClose = true
                    this.driver.options.isEditMode = false
                    this.selectorChoices = []
                    this.selectorChoiceIndex = 0
                    this.step = null
                }
            },
            isHighlightSelectionActive(value) {
                if (value) {
                    this.updateUserAction(userActions.creatingHighlight)
                }
            }
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
                const updatedStep = this.createStep(activeElement)
                if (this.step) {
                    this.$emit('saveClick', {
                        ...this.step,
                        ...updatedStep,
                    })
                } else {
                    this.$emit('saveClick', updatedStep)
                }
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
                if (!this.isHighlightSelectionActive) return;
                // omotenashiの要素のクリックは無視
                if (e.composedPath().find(el => el.id === 'omotenashi')) return
                e.preventDefault() // for driver.js
                e.stopPropagation() // for driver.js
                if (this.isSelectingHighlight) {
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
            highlight({ id = null, element, popover={ content: '<div><h1>Title</h1><div>Your description here</div></div>' } }) {
                let el = element
                let po = popover

                if (!this.step) {
                    this.step = id ? this.steps.find(s => s.id === id) : this.steps.find(s => s.element === element)
                    if (this.step) {
                        el = this.step.element
                        po = this.step.popover
                    }
                }

                if (!this.isSelectingHighlight) {
                    this.updateUserAction(userActions.selectingHighlight)
                }

                this.driver.options.allowClose = false
                this.driver.options.isEditMode = true

                this.driver.highlight({
                    element: el,
                    popover: po,
                })

                if (this.isHighlightSelectionActive && this.isSelectingHighlight) {
                    this.selectorChoiceIndex += 1
                }
            },
            preview() {
                this.driver.options.allowClose = true
                this.driver.options.onReset = () => {
                    this.updateUserAction(userActions.creatingHighlight)
                }
                this.driver.defineSteps(this.steps)
                this.driver.start()
                this.updateUserAction(userActions.previewing)
            },
            showAnotherChoice() {
                if (!this.isSelectingHighlight) return
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