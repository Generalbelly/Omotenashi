import { shallowMount } from '@vue/test-utils'
import BaseMessage from '../../ext/js/components/BaseMessage'

describe('BaseMessage.vue', () => {

    const header = 'header testing'
    const body = 'body is one thing, head is another thing.'
    const messageClass = ['one', 'two', 'three', 'four']

    describe(':props', () => {
        it(':header - should render a message header with the passed-in header text', () => {
            const wrapper = shallowMount(BaseMessage, {
                propsData: {
                    header,
                }
            })
            expect(wrapper.find('div.message-header > p').text()).to.equal(header)
        })

        it(':body - should render a message body with the passed-in body text', () => {
            const wrapper = shallowMount(BaseMessage, {
                propsData: {
                    body,
                }
            })
            expect(wrapper.find('div.message-body').text()).to.equal(body)
        })

        it(':messageClass - should render a message with the passed-in classes', () => {
            const wrapper = shallowMount(BaseMessage, {
                propsData: {
                    messageClass,
                }
            })
            expect(wrapper.contains('article.message.'+messageClass.join('.'))).to.equal(true)
        })

        it(':dontShowMeOption - should render a checkbox with the text of "Don\'t show me this message again", if the prop is true', () => {
            const wrapper = shallowMount(BaseMessage, {
                propsData: {
                    dontShowMeOption: true,
                    body,
                }
            })
            expect(wrapper.contains('p.has-margin-top-3 > label.checkbox > input[type="checkbox"]')).to.equal(true)
            expect(wrapper.find('p.has-margin-top-3 > label.checkbox').text()).to.equal("Don't show me this message again.")

            wrapper.setProps({
                dontShowMeOption: false,
            })
            expect(wrapper.contains('p.has-margin-top-3 > label.checkbox > input[type="checkbox"]')).to.equal(false)
        })
    })
})
