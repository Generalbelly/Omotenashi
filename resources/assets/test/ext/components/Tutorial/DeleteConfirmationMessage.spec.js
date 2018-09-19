import { shallowMount } from '@vue/test-utils'
import DeleteConfirmationMessage from '../../../../ext/js/components/Tutorial/DeleteConfirmationMessage'
import BaseMessage from '../../../../ext/js/components/BaseMessage'
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

            const deleteButton = wrapper.find('button.button.is-danger.is-fullwidth')

            deleteButton.trigger('click')

            // The button has disable html attribute,
            // so you are not suppose to be able to click and the event wont'be emitted.
            expect(wrapper.emitted()).to.not.have.property('deleteClick');

            wrapper.setData({
                tutorialName: tutorial.name,
            })

            deleteButton.trigger('click')

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

})
