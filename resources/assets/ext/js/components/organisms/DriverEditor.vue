<template>
    <div
        v-show="isEdit"
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

    export const states = {
        initial: 'initial',
        edit: 'edit',
        preview: 'preview',
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
                initial: false,
            },
            steps: {
                type: Array,
                initial() {
                    return []
                },
            },
        },
        data() {
            return {
                driver: null,
                state: null,
                selectorChoices: [],
                selectorChoiceIndex: 0,
                maxRetries: 5,
                step: null,
            }
        },
        computed: {
            isDefault() {
                return this.state === states.initial
            },
            isEdit() {
                return this.state === states.edit
            },
        },
        watch: {
            state(newValue, oldValue) {
                if (oldValue == states.preview) {
                    this.$emit('previewDone')
                }

                if (oldValue === states.edit) {
                    this.driver.reset()
                    this.driver.options.allowClose = true
                    this.driver.options.isEditMode = false
                    this.selectorChoices = []
                    this.selectorChoiceIndex = 0
                    this.step = null
                    this.$emit('editDone')
                }
            },
            isHighlightSelectionActive(value) {
                if (value) {
                    this.updateState(states.initial)
                }
            }
        },
        methods: {
            updateState(state = null) {
                if (Object.values(states).includes(state)) {
                    this.state = state
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
                this.updateState(states.initial)
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
                this.updateState(states.initial)
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
                if (this.isEdit) {
                    if (e.target.id === 'om-adding-step-cancel' || e.target.id === 'om-adding-step-save') return
                    if (this.selectorChoices.length > 0) {
                        this.showAnotherChoice()
                    }
                } else if (this.isDefault) {
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

                if (!this.isEdit) {
                    this.updateState(states.edit)
                }

                // watchdeでセットすると遅いのでここでやってる
                this.driver.options.allowClose = false
                this.driver.options.isEditMode = true

                this.driver.highlight({
                    element: el,
                    popover: po,
                })

                if (this.isHighlightSelectionActive && this.isEdit) {
                    this.selectorChoiceIndex += 1
                }
            },
            preview() {
                this.driver.options.allowClose = true
                this.driver.options.onReset = () => {
                    this.updateState(states.initial)
                }
                this.driver.defineSteps(this.steps)
                this.driver.start()
                this.updateState(states.preview)
            },
            showAnotherChoice() {
                if (!this.isEdit) return
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