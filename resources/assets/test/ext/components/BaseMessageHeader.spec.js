import { shallowMount } from '@vue/test-utils'
import BaseMessageHeader from '../../../ext/js/components/BaseMessageHeader'
import Vue from '../app'

describe('BaseMessageHeader.vue', () => {

    describe('slots', () => {
        it('slots - should be rendered with slot', () => {

            const fakeMessage = '<div class="fake-message">fake message</div>'
            const wrapper = shallowMount(BaseMessageHeader, {
                localVue: Vue,
                slots: {
                    default: fakeMessage
                }
            })

            expect(wrapper.find('.fake-message').text()).to.equal('fake message')

        })
    })

})
