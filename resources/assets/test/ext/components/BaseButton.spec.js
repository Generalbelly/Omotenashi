import { shallowMount } from '@vue/test-utils'
import BaseButton from '../../../ext/js/components/BaseButton'
import Vue from "../app";

describe('BaseButton.vue', () => {

    describe(':props', () => {

        it(':classes - should be converted to class', () => {

            const classes = [
                'one',
                'two',
                'three',
            ]

            const wrapper = shallowMount(BaseButton, {
                localVue: Vue,
                propsData: {
                    classes,
                },
            })

            expect(wrapper.contains('button.'+classes.join('.'))).to.equal(true)

        })

    })

    describe('@events', () => {

        it('@click - should be emitted when button element is clicked', () => {

            const wrapper = shallowMount(BaseButton, {
                localVue: Vue,
            })

            const button = wrapper.find('button')

            button.trigger('click')

            expect(wrapper.emitted().click.length).to.equal(1)

        })

    })

})
