<template>
    <div>
        <Message
            v-show="hasClickToAddStepMessage && showClickToAddStepMessage"
            :has-dont-show-me-option="true"
            :dont-show-me="!hasClickToAddStepMessage"
            is-info
            @closeClick="showClickToAddStepMessage = false"
            @dontShowMeChange="e => $emit('dontShowMeChange', { messageKey: 'clickToAddStep', value: e })"
        >
            <template slot="header">Tips</template>
            <template slot="body">
                Click to select and edit text.
            </template>
        </Message>
        <Message
            v-show="showNoMoreSelectorChoicesMessage"
            is-warning
            @closeClick="showNoMoreSelectorChoicesMessage = false"
        >
            <template slot="header">Oops</template>
            <template slot="body">
                Looks like we don't have any other options to show you.
            </template>
        </Message>

        <Message
            v-show="hasSelectorChoicesAvailableMessage && showSelectorChoicesAvailableMessage"
            :has-dont-show-me-option="true"
            :dont-show-me="!hasSelectorChoicesAvailableMessage"
            is-info
            @closeClick="showSelectorChoicesAvailableMessage = false"
            @dontShowMeChange="e => $emit('dontShowMeChange', { messageKey: 'selectorChoicesAvailable', value: e })"
        >
            <template slot="header">Tips</template>
            <template slot="body">
                Selections start small.<br>
                The more you click, the larger your section to edit will become.<br>
                To select a different small section, press cancel and click a new section.
            </template>
        </Message>

        <Message
            v-show="showNoStepAddedYetMessage"
            is-warning
            @closeClick="showNoStepAddedYetMessage = false"
        >
            <template slot="header">Oops</template>
            <template slot="body">
                You haven't added any steps yet.
            </template>
        </Message>

        <div
            v-show="isEdit"
        >
            <div class="has-padding-4 is-fixed-bottom-right editor-action">
                <BaseButton
                    id="om-adding-step-save"
                    @click="onSaveClick"
                    is-primary
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
        </div>
    </div>
</template>

<script>
    import finder from '@medv/finder'
    import purify from 'dompurify'
    import Driver from '../../../../../driver.js/driver.min'
    import BaseButton from '../../atoms/BaseButton'
    import Message from '../../molecules/Message'

    export const states = {
        initial: 'initial',
        edit: 'edit',
        preview: 'preview',
    }

    export default {
        name: "DriverEditor",
        components: {
            BaseButton,
            Message,
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
            hasSelectorChoicesAvailableMessage: {
                type: Boolean,
                default: true,
            },
            hasClickToAddStepMessage: {
                type: Boolean,
                default: true,
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
                showNoMoreSelectorChoicesMessage: false,
                showSelectorChoicesAvailableMessage: false,
                showClickToAddStepMessage: false,
                showNoStepAddedYetMessage: false,
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
            isHighlightSelectionActive: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.showClickToAddStepMessage = true
                        this.updateState(states.initial)
                    }
                }
            },
        },
        created() {
            window.parent.postMessage({
               activate: true,
            }, window.top.location.origin);
            // this.driver = new Driver({
            //     animate: false,
            // })
        },
        destroyed() {
            this.driver = null
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
                console.log('called');
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
                    this.showClickToAddStepMessage = false

                    if (this.selectorChoices.length === 0) {
                        this.selectorChoices = this.extractSelectorChoices(e)
                    }

                    const selector = this.selectorChoices[this.selectorChoiceIndex]
                    this.highlight({
                        element: selector,
                    })

                    this.showSelectorChoicesAvailableMessage = true
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
                if (this.steps.length === 0) {
                    this.showNoStepAddedYetMessage = true
                    return
                }

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
                    this.showNoMoreSelectorChoicesMessage = true
                    this.selectorChoiceIndex = 0
                } else {
                    this.highlight({
                        element: this.selectorChoices[this.selectorChoiceIndex]
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .editor-action {
        height: 50px;
        z-index: 100004;
    }
</style>