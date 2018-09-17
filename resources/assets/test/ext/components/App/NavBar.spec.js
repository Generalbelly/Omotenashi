import { shallowMount } from '@vue/test-utils'
import NavBar from '../../../../ext/js/components/App/Navbar'
import Vue from '../../app'

describe('NavBar.vue', () => {

    describe('@events', () => {

        it('@actionClick - should be emitted when the action button is clicked', () => {

            const wrapper = shallowMount(NavBar, {
                localVue: Vue,
            })

            const actionButton = wrapper.find('button.is-success')

            actionButton.trigger('click')

            expect(wrapper.emitted().actionClick.length).to.equal(1)

        })

    })

    describe('html attributes', () => {

        it('a tag href - should feedback page url', () => {

            const wrapper = shallowMount(NavBar, {
                localVue: Vue,
            })

            const aTag = wrapper.find('p.level-item > a')

            expect(aTag.attributes().href).to.equal('#')

        })

    })
})
