import { shallowMount } from '@vue/test-utils'
import Setting from '../../../../ext/js/components/Tutorial/Setting'
import Vue from '../../app'

describe('BaseMessage.vue', () => {

    let tutorial

    beforeEach(() => {
        tutorial = {
            name: 'Awesome Tutorial',
            description: 'This tutorial is awesome.',
        }
    })

    describe(':props', () => {

        it(':tutorial - should render a message header with the passed-in header text', done => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
            })

            expect(wrapper.find('header.modal-card-head > p.modal-card-title').text()).to.equal('Create Tutorial')

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')

            wrapper.setProps({
                tutorial,
            })

            expect(wrapper.vm.$data.updatedTutorial.name).to.equal(tutorial.name)

            expect(wrapper.vm.$data.updatedTutorial.description).to.equal(tutorial.description)

            wrapper.vm.$nextTick(() => {

                expect(wrapper.find('header.modal-card-head > p.modal-card-title').text()).to.equal('Edit Tutorial')

                done()
            })

        })
    })

    describe('@events', () => {

        it('@cancelClick - should be emitted, when the cancel button is clicked', () => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
                tutorial,
            })

            const cancelButton = wrapper.find('footer > button:nth-child(2)')

            cancelButton.trigger('click')

            expect(wrapper.emitted().cancelClick.length).to.equal(1)

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')

        })

        it('@saveClick - should be emitted, when the save button is clicked', done => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
            })

            const saveButton = wrapper.find('footer > button:nth-child(1).is-success')

            saveButton.trigger('click')

            expect(wrapper.emitted().saveClick.length).to.equal(1)

            expect(wrapper.emitted().saveClick[0][0].name).to.equal('')

            expect(wrapper.emitted().saveClick[0][0].description).to.equal('')

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')

            expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')

            wrapper.setProps({
                tutorial,
            })

            saveButton.trigger('click')

            wrapper.vm.$nextTick(() => {

                expect(wrapper.emitted().saveClick.length).to.equal(2)

                expect(wrapper.emitted().saveClick[1][0].name).to.equal(tutorial.name)

                expect(wrapper.emitted().saveClick[1][0].description).to.equal(tutorial.description)

                expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')

                expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')

                done()

            })

        })

    })

})
