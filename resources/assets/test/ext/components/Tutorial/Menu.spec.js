import { shallowMount, mount } from '@vue/test-utils'
import Menu from '../../../../ext/js/components/Tutorial/Menu'
import BaseButton from '../../../../ext/js/components/BaseButton'
import Vue from '../../app'
import { tutorials } from '../../mock'

describe('Menu.vue', () => {

    let selectedTutorial
    let selectedStep

    beforeEach(() => {
        selectedTutorial = tutorials[0]
        selectedStep = selectedTutorial.steps[0]
    })

    describe(':props', () => {

        it(':tutorials - should render a delete message if the length of these is more than one', done => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
            })

            const deleteTutorialButton = wrapper.findAll(BaseButton).at(2)

            expect(deleteTutorialButton.text()).to.equal('Delete')
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

            const addTutorialButton = wrapper.findAll(BaseButton).at(0)
            addTutorialButton.vm.$emit('click')

            expect(addTutorialButton.text()).equal('Add')
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

            const editTutorialButton = wrapper.findAll(BaseButton).at(1)
            expect(editTutorialButton.text()).to.equal('Edit')
            editTutorialButton.vm.$emit('click')

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

            const deleteTutorialButton = wrapper.findAll(BaseButton).at(2)
            expect(deleteTutorialButton.text()).to.equal('Delete')
            deleteTutorialButton.vm.$emit('click')
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

            const addStepButton = wrapper.findAll(BaseButton).at(3)
            expect(addStepButton.text()).to.equal('Add Step')
            addStepButton.vm.$emit('click')

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

            const previewButton = wrapper.findAll(BaseButton).at(4)
            expect(previewButton.text()).to.equal('Preview')
            previewButton.vm.$emit('click')

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
