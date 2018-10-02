import { shallowMount } from '@vue/test-utils'
import DeleteConfirmationMessage from '../../../../ext/js/components/organisms/DeleteConfirmationMessage'
import BaseMessage from '../../../../ext/js/components/atoms/BaseMessage'
import BaseButton from '../../../../ext/js/components/atoms/BaseButton'
import Vue from '../../app'

describe('DeleteConfirmationMessage.vue', () => {

    let tutorial

    beforeEach(() => {
        tutorial = {
            id: '953c909a-e446-43fb-aea2-e07fa29716e9',
            name: 'Awesome Tutorial',
            description: 'This tutorial is awesome.',
        }
    })

    describe('@events', () => {

        it('@deleteClick - should be emitted, when the delete button is clicked', () => {

            const wrapper = shallowMount(DeleteConfirmationMessage, {
                localVue: Vue,
                propsData: {
                    tutorial,
                },
            })

            const deleteButton = wrapper.find(BaseButton)
            deleteButton.vm.$emit('click')

            expect(wrapper.emitted().deleteClick.length).to.equal(1)

        })

        it('@closeClick - should be emitted, when BaseMessage emit "closeClick"', () => {

            const wrapper = shallowMount(DeleteConfirmationMessage, {
                localVue: Vue,
            })

            const baseMessage = wrapper.find(BaseMessage)

            baseMessage.vm.$emit('closeClick')

            expect(wrapper.emitted().closeClick.length).to.equal(1)

        })

    })

    describe('User interaction', () => {

        it('deleteButton - should be disabled unless the user type in the tutorial name', () => {

            const wrapper = shallowMount(DeleteConfirmationMessage, {
                localVue: Vue,
                propsData: {
                    tutorial,
                },
            })

            const deleteButton = wrapper.find(BaseButton)

            expect(deleteButton.vm.$props.disabled).to.equal(true)

            wrapper.setData({
                tutorialName: tutorial.name,
            })

            expect(deleteButton.vm.$props.disabled).to.equal(false)

        })
    })

})
