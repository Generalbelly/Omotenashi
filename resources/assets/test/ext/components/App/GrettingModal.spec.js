import { shallowMount } from '@vue/test-utils'
import GreetingModal from '../../../../ext/js/components/organisms/GreetingModal'
import BaseModal from '../../../../js/components/molecules/Modal/Modal'
import BaseButton from '../../../../js/components/atoms/BaseButton/BaseButton'
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
