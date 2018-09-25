// import { shallowMount } from '@vue/test-utils'
// import BaseMessage from '../../../ext/js/components/BaseMessage'
// import BaseMessageHeader from '../../../ext/js/components/BaseMessageHeader'
// import BaseMessageBody from '../../../ext/js/components/BaseMessageBody'
// import Vue from '../app'
//
// describe('HelpMessage.vue', () => {
//
//     const header = 'header testing'
//     const body = 'body is one thing, head is another thing.'
//     const messageClasses = ['one', 'two', 'three', 'four']
//
//     describe(':props', () => {
//         it(':header - should render a message header with the passed-in header text', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     header,
//                 }
//             })
//             expect(wrapper.find('div.message-header').text()).to.equal(header)
//         })
//
//         it(':body - should render a message body with the passed-in body text', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     body,
//                 },
//             })
//             expect(wrapper.find('div.message-body').text()).to.equal(body)
//         })
//
//         it(':messageClasses - should render a message with the passed-in classes', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     messageClasses,
//                 }
//             })
//             expect(wrapper.contains('article.message.'+messageClasses.join('.'))).to.equal(true)
//         })
//
//         it(':hasDontShowMeOption - should render a checkbox with the text of "Don\'t show me this message again", if the prop is true', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     hasDontShowMeOption: true,
//                 }
//             })
//             expect(wrapper.contains('label.checkbox > input[type="checkbox"]')).to.equal(true)
//             expect(wrapper.find('label.checkbox').text()).to.equal("Don't show me this message again.")
//
//             wrapper.setProps({
//                 hasDontShowMeOption: false,
//             })
//
//             expect(wrapper.contains('label.checkbox > input[type="checkbox"]')).to.equal(false)
//         })
//
//         it(':dontShowMeChenge - should render a checked or unchecked checkbox, depending on the prop value', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     hasDontShowMeOption: true,
//                     dontShowMeChenge: false,
//                 }
//             })
//
//             const checkBox = wrapper.find('label.checkbox > input')
//
//             expect(checkBox.element.checked).to.equal(false)
//
//             wrapper.setProps({
//                 dontShowMeChenge: true,
//             })
//
//             expect(checkBox.element.checked).to.equal(true)
//
//         })
//     })
//
//     describe('slot', () => {
//         it('header - should render header slot', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 slots: {
//                     header: '<h1>Omotenashi</h1>'
//                 }
//             })
//
//             expect(wrapper.find('h1').text()).to.equal('Omotenashi')
//         })
//
//         it('body - should render body slot', () => {
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 slots: {
//                     header: '<h2>Omotenashi</h2>'
//                 }
//             })
//
//             expect(wrapper.find('h2').text()).to.equal('Omotenashi')
//         })
//
//     })
//
//     describe('@events', () => {
//         it('@closeClick - should be emitted when the close button is clicked and anywhere outside of the message is clicked', () => {
//
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//             })
//
//             const closeButton = wrapper.find('button.delete')
//             closeButton.trigger('click')
//
//             expect(wrapper.emitted().closeClick.length).to.equal(1)
//
//             const outside = wrapper.find('.message__container')
//             outside.trigger('click')
//
//             expect(wrapper.emitted().closeClick.length).to.equal(2)
//
//
//         })
//
//         it('@dontShowMeChenge - should be emitted when the checkbox is checked', ()=> {
//
//             const wrapper = shallowMount(BaseMessage, {
//                 localVue: Vue,
//                 propsData: {
//                     hasDontShowMeOption: true,
//                 }
//             })
//
//             const checkBox = wrapper.find('label.checkbox > input[type="checkbox"]')
//
//             expect(checkBox.element.checked).to.equal(false)
//
//             checkBox.setChecked()
//
//             expect(wrapper.emitted().dontShowMeChenge.length).to.equal(1)
//
//             expect(wrapper.emitted().dontShowMeChenge[0][0]).to.equal(true)
//
//         })
//
//     })
// })
