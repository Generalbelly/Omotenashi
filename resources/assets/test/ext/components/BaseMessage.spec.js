import { shallowMount } from '@vue/test-utils'
import BaseMessage from '../../../js/components/atoms/BaseMessage'
import Vue from '../app'

describe('BaseMessage.vue', () => {

    describe('@events', () => {
        it('@closeClick - should be emitted when the close button is clicked and anywhere outside of the message is clicked', () => {

            const wrapper = shallowMount(BaseMessage, {
                localVue: Vue,
            })

            const container = wrapper.find('div:nth-child(1)')
            container.trigger('click')

            expect(wrapper.emitted().closeClick.length).to.equal(1)

        })
    })

    describe('slots', () => {
        it('slots - should be rendered with slot', () => {

            const fakeMessage = '<div class="fake-message">fake message</div>'
            const wrapper = shallowMount(BaseMessage, {
                localVue: Vue,
                slots: {
                    default: fakeMessage
                }
            })

            expect(wrapper.find('.fake-message').text()).to.equal('fake message')

        })
    })
})
