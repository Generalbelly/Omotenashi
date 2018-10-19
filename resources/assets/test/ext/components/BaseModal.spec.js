import { shallowMount } from '@vue/test-utils'
import BaseModal from '../../../js/components/molecules/Modal'
import Vue from '../app'

describe('BaseModal.vue', () => {

    const modalContentClasses = ['one', 'two', 'three', 'four']
    const contentClasses = ['one', 'two', 'three', 'four']

    describe(':props', () => {
        it(':showClose - should render a modal with or without a close button, depending on the value', () => {
            const wrapper = shallowMount(BaseModal, {
                localVue: Vue,
                propsData: {
                    showClose: false,
                }
            })

            expect(wrapper.contains('button.modal-close.is-large.is-paddingless')).to.equal(false)

            wrapper.setProps({ showClose: true })

            expect(wrapper.contains('button.modal-close.is-large.is-paddingless')).to.equal(true)

            const closeButton = wrapper.find('button.modal-close.is-large.is-paddingless')
            closeButton.trigger('click')

            expect(wrapper.emitted().closeClick.length).to.equal(1)

        })

        it(':modalContentClasses - should render a message with the passed-in classes', () => {
            const wrapper = shallowMount(BaseModal, {
                localVue: Vue,
                propsData: {
                    modalContentClasses,
                }
            })

            expect(wrapper.contains('div.modal-content.'+modalContentClasses.join('.'))).to.equal(true)

        })

        it(':contentClasses - should render a message with the passed-in classes', () => {
            const wrapper = shallowMount(BaseModal, {
                localVue: Vue,
                propsData: {
                    contentClasses,
                }
            })

            expect(wrapper.contains('div.content.'+contentClasses.join('.'))).to.equal(true)

        })
    })

    describe('slot', () => {
        it('content - should render slot content', () => {

            const wrapper = shallowMount(BaseModal, {
                localVue: Vue,
                slots: {
                    content: '<h1>Omotenashi</h1>'
                }
            })

            expect(wrapper.find('h1').text()).to.equal('Omotenashi')
        })

    })

})
