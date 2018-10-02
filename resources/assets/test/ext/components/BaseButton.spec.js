import { shallowMount } from '@vue/test-utils'
import BaseButton from '../../../ext/js/components/atoms/BaseButton'
import Vue from "../app";

describe('BaseButton.vue', () => {

    describe(':props', () => {

        it(':isOutlined - should be included in buttonClass', () => {

            const wrapper = shallowMount(BaseButton, {
                localVue: Vue,
                propsData: {
                    isOutlined: true
                }
            })

            expect(wrapper.classes().includes('is-outlined')).to.equal(true)

        })

        it(':isFullwidth - should be included in buttonClass', () => {

            const wrapper = shallowMount(BaseButton, {
                localVue: Vue,
                propsData: {
                    isFullwidth: true
                }
            })

            expect(wrapper.classes().includes('is-fullwidth')).to.equal(true)

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
