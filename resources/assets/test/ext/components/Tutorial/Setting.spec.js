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

        it(':tutorial - should render a message header with the passed-in header text', () => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
            })

            expect(wrapper.find('header.modal-card-head > p.modal-card-title').text()).to.equal('Create Tutorial')
            expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')
            expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')

            wrapper.setProps({
                tutorial,
            })

            window.setTimeout(() => {
                expect(wrapper.find('header.modal-card-head > p.modal-card-title').text()).to.equal('Edit Tutorial')
                expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal(tutorial.name)
                expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal(tutorial.description)
            }, 100)
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

        it('@saveClick - should be emitted, when the save button is clicked', () => {
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
            window.setTimeout(() => {
                expect(wrapper.emitted().saveClick.length).to.equal(2)
                expect(wrapper.emitted().saveClick[1][0].name).to.equal(tutorial.name)
                expect(wrapper.emitted().saveClick[1][0].description).to.equal(tutorial.description)
                expect(wrapper.find('section.modal-card-body > div.field:nth-child(1) > div.control input[type="text"]').text()).to.equal('')
                expect(wrapper.find('section.modal-card-body > div.field:nth-child(2) > div.control textarea').text()).to.equal('')
            }, 100)

        })
    })



    // describe('slot', () => {
    //     it('header - should render header slot', () => {
    //         const wrapper = shallowMount(BaseMessage, {
    //             localVue: Vue,
    //             slots: {
    //                 header: '<h1>Omotenashi</h1>'
    //             }
    //         })
    //
    //         expect(wrapper.find('h1').text()).to.equal('Omotenashi')
    //     })
    //
    //     it('body - should render body slot', () => {
    //         const wrapper = shallowMount(BaseMessage, {
    //             localVue: Vue,
    //             slots: {
    //                 header: '<h2>Omotenashi</h2>'
    //             }
    //         })
    //
    //         expect(wrapper.find('h2').text()).to.equal('Omotenashi')
    //     })
    //
    // })
    //
    // describe('@events', () => {
    //     it('@closeClick - should be emitted when the close button is clicked and anywhere outside of the message is clicked', () => {
    //
    //         const wrapper = shallowMount(BaseMessage, {
    //             localVue: Vue,
    //         })
    //
    //         const closeButton = wrapper.find('button.delete')
    //         closeButton.trigger('click')
    //
    //         expect(wrapper.emitted().closeClick.length).to.equal(1)
    //
    //         const outside = wrapper.find('.message__container')
    //         outside.trigger('click')
    //
    //         expect(wrapper.emitted().closeClick.length).to.equal(2)
    //
    //
    //     })
    //
    //     it('@dontShowMeChecked - should be emitted when the checkbox is checked', ()=> {
    //
    //         const wrapper = shallowMount(BaseMessage, {
    //             localVue: Vue,
    //             propsData: {
    //                 dontShowMeOption: true,
    //             }
    //         })
    //
    //         const checkBox = wrapper.find('label.checkbox > input[type="checkbox"]')
    //
    //         expect(checkBox.element.checked).to.equal(false)
    //
    //         checkBox.setChecked()
    //
    //         expect(wrapper.emitted().dontShowMeChecked.length).to.equal(1)
    //         expect(wrapper.emitted().dontShowMeChecked[0][0]).to.equal(true)
    //
    //     })
    //
    // })
})
