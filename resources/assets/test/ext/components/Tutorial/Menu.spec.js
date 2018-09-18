import { shallowMount } from '@vue/test-utils'
import Menu from '../../../../ext/js/components/Tutorial/Menu'
import Vue from '../../app'

describe('Menu.vue', () => {

    let tutorials
    // let selectedTutorial
    // let selectedStep

    beforeEach(() => {
        tutorials = [
            {
                name: 'Awesome Tutorial',
                description: 'This tutorial is awesome.',
            },
            {
                name: 'OK Tutorial',
                description: 'This tutorial is okay.',
            },
            {
                name: 'Bad tutorial',
                description: 'This tutorial is bad.',
            }
        ]
    })

    describe(':props', () => {

        it(':tutorials - should show a delete message is tutorials length is more than one', done => {

            const wrapper = shallowMount(Menu, {
                localVue: Vue,
            })

            const deleteButton = wrapper.find('div.field > div.control:nth-child(2) > button')

            expect(deleteButton.isVisible()).to.equal(false)

            wrapper.setProps({
                tutorials
            })

            wrapper.vm.$nextTick(() => {

                expect(deleteButton.isVisible()).to.equal(true)

                expect(deleteButton.text()).to.equal('Delete')

                done()
            })

        })
    })

})
