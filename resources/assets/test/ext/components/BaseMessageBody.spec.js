import { shallowMount } from '@vue/test-utils'
import BaseMessageBody from '../../../ext/js/components/BaseMessageBody'
import Vue from '../app'

describe('BaseMessageBody.vue', () => {

    describe('slots', () => {
        it('slots - should be rendered with slot', () => {

            const fakeMessage = '<div class="fake-message">fake message</div>'
            const wrapper = shallowMount(BaseMessageBody, {
                localVue: Vue,
                slots: {
                    default: fakeMessage
                }
            })

            expect(wrapper.find('.fake-message').text()).to.equal('fake message')

        })
    })

})
