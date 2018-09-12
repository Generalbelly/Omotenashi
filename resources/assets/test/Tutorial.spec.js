import { shallowMount } from '@vue/test-utils'
import Tutorial from '../ext/js/features/Tutorial'

describe('Tutorial', () => {
    it('test', () => {
        const wrapper = shallowMount(Tutorial)
        expect(wrapper.find('div').text()).toMatch('1')
    })
})