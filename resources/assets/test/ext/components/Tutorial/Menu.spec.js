import { shallowMount, mount } from '@vue/test-utils'
import Menu from '../../../../ext/js/components/Tutorial/Menu'
import Vue from '../../app'

describe('Menu.vue', () => {

    let tutorials
    let selectedTutorial
    let selectedStep

    beforeEach(() => {
        tutorials = [
            {
                id: '953c909a-e446-43fb-aea2-e07fa29716e9',
                name: 'Awesome Tutorial',
                description: 'This tutorial is awesome.',
                steps: [
                    {
                        id: '383c930a-e446-21fb-aea3-e07fa29716e3',
                        element: '.flex .flex > .primary > .btn__content',
                        popover: {
                            content: '<div><h1>Title</h1><div>Some description here</div></div>',
                        }
                    },
                    {
                        id: '283c930a-e339-00fb-aea2-e07fa29716e4',
                        element: '.flex .flex > .primary > .btn__content',
                        popover: {
                            content: '<div><h1>Title</h1><div>Some description here</div></div>',
                        }
                    }
                ],
            },
            {
                id: '953c690c-e446-32fb-aea2-e07fa29716e8',
                name: 'OK Tutorial',
                description: 'This tutorial is okay.',
                steps: [],
            },
            {
                id: '888c909a-e323-13fb-aea2-e07fa29316e7',
                name: 'Bad tutorial',
                description: 'This tutorial is bad.',
                steps: [],
            }
        ]

        selectedTutorial = tutorials[0]
        selectedStep = selectedTutorial.steps[0]

    })

    describe(':props', () => {

        it(':tutorials - should render a delete message if the length of these is more than one', done => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
            })

            const deleteTutorialButton = wrapper.find('.field > .control:nth-child(2) > button')

            expect(deleteTutorialButton.isVisible()).to.equal(false)

            wrapper.setProps({
                tutorials
            })

            wrapper.vm.$nextTick(() => {
                expect(deleteTutorialButton.isVisible()).to.equal(true)
                expect(deleteTutorialButton.text()).to.equal('Delete')
                done()
            })

        })

        it(':selectedTutorial - the id should be passed to selectedTutorialId in data property', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    selectedTutorial,
                }
            })

            expect(wrapper.vm.$data.selectedTutorialId).to.equal(selectedTutorial.id)

        })

        it(':selectedTutorial, selectedStep - should render a list of steps if it is not null', done => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
            })

            expect(wrapper.contains('a.panel-block')).to.equal(false)

            wrapper.setProps({
                selectedTutorial,
                selectedStep,
            })

            wrapper.vm.$nextTick(() => {
                expect(wrapper.contains('a.panel-block')).to.equal(true)
                done()
            })

        })
    })

    describe('@events', () => {

        it('@addTutorialClick - should be emitted when "Add" button click', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    selectedTutorial,
                    selectedStep
                }
            })

            const addTutorialButton = wrapper.find('p.panel-heading > button.button')
            addTutorialButton.trigger('click')

            expect(wrapper.emitted().addTutorialClick.length).equal(1)

        })

        it('@tutorialChange - should be emitted when another tutorial is selected', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep
                }
            })

            const select = wrapper.find('span.select > select')
            select.trigger('change')

            expect(wrapper.emitted().tutorialChange.length).equal(1)

        })

        it('@editTutorialClick - should be emitted when "Edit" button is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep
                }
            })

            const editTutorialButton = wrapper.find('p.control:nth-child(1) > button.button')
            editTutorialButton.trigger('click')

            expect(wrapper.emitted().editTutorialClick.length).equal(1)

        })

        it('@deleteTutorialClick - should be emitted when "Delete" button is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep
                }
            })

            const deleteTutorialButton = wrapper.find('.field > .control:nth-child(2) > button')
            deleteTutorialButton.trigger('click')
            expect(wrapper.emitted().deleteTutorialClick.length).equal(1)

        })

        it('@deleteStepClick - should be emitted when a trash icon next to a step is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const deleteStepButton = wrapper.find('a.panel-block > span:nth-child(2)')
            deleteStepButton.trigger('click')

            expect(wrapper.emitted().deleteStepClick.length).equal(1)

        })

        it('@stepClick - should be emitted when a step is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const step = wrapper.find('a.panel-block > span:nth-child(1)')
            step.trigger('click')

            expect(wrapper.emitted().stepClick.length).equal(1)

        })

        it('@addStepClick - should be emitted when "Add step" is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const addStepButton = wrapper.find('div.panel-block > button.is-link')
            addStepButton.trigger('click')

            expect(wrapper.emitted().addStepClick.length).equal(1)

        })

        it('@previewClick - should be emitted when "Preview" is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const previewButton = wrapper.find('div.panel-block > button.is-primary')
            previewButton.trigger('click')

            expect(wrapper.emitted().previewClick.length).equal(1)

        })

        it('@switchSideClick - should be emitted when the switch icon is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const switchButton = wrapper.find('div.panel-block > span.has-cursor-pointer.icon:nth-child(1)')
            switchButton.trigger('click')

            expect(wrapper.emitted().switchSideClick.length).equal(1)

        })

        it('@homeClick - should be emitted when the home icon is clicked', () => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
                propsData: {
                    tutorials,
                    selectedTutorial,
                    selectedStep,
                }
            })

            const homeButton = wrapper.find('div.panel-block > span.has-cursor-pointer.icon:nth-child(2)')
            homeButton.trigger('click')

            expect(wrapper.emitted().homeClick.length).equal(1)

        })


    })

})
