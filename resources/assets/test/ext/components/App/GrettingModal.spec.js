import { shallowMount } from '@vue/test-utils'
import GreetingModal from '../../../../ext/js/components/App/GreetingModal'
import BaseModal from '../../../../ext/js/components/BaseModal'
import BaseButton from '../../../../ext/js/components/BaseButton'
import Vue from '../../app'

describe('GreetingModal.vue', () => {

    describe('@events', () => {
        it('@closeClick - should be emitted when BaseModal component emit "closeClick" event', () => {

            const wrapper = shallowMount(GreetingModal, {
                localVue: Vue,
            })

            const baseModal = wrapper.find(BaseModal)

            baseModal.vm.$emit('closeClick')

            expect(wrapper.emitted().closeClick.length).to.equal(1)
        })

        it('@startClick - should be emitted when the button is clicked', () => {

            const wrapper = shallowMount(GreetingModal, {
                localVue: Vue,
            })

            const button = wrapper.find(BaseButton)

            button.vm.$emit('click')

            expect(wrapper.emitted().startClick.length).to.equal(1)

        })
    })
})
