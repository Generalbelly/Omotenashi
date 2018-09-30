import { shallowMount } from '@vue/test-utils'
import Setting from '../../../../ext/js/components/Tutorial/Setting'
import BaseModalCard from '../../../../ext/js/components/BaseModalCard'
import BaseModalCardHeader from '../../../../ext/js/components/BaseModalCardHeader'
import BaseModalCardFooter from '../../../../ext/js/components/BaseModalCardFooter'
import BaseTextField from '../../../../ext/js/components/BaseTextField'
import BaseTextArea from '../../../../ext/js/components/BaseTextArea'
import BaseButton from '../../../../ext/js/components/BaseButton'
import Vue from '../../app'

describe('Setting.vue', () => {

    let tutorial

    beforeEach(() => {
        tutorial = {
            id: '953c909a-e446-43fb-aea2-e07fa29716e9',
            name: 'Awesome Tutorial',
            description: 'This tutorial is awesome.',
        }
    })

    describe(':props', () => {

        it(':tutorial - should render a message header with the passed-in header text', done => {

            const wrapper = shallowMount(Setting, {
                localVue: Vue,
            })

            expect(wrapper.find(BaseModalCardHeader).text()).to.equal('Create Tutorial')

            expect(wrapper.find(BaseTextField).text()).to.equal('')

            expect(wrapper.find(BaseTextArea).text()).to.equal('')

            wrapper.setProps({
                tutorial,
            })

            expect(wrapper.vm.$data.updatedTutorial.name).to.equal(tutorial.name)

            expect(wrapper.vm.$data.updatedTutorial.description).to.equal(tutorial.description)

            wrapper.vm.$nextTick(() => {

                expect(wrapper.find(BaseModalCardHeader).text()).to.equal('Edit Tutorial')

                done()
            })

        })
    })

    describe('@events', () => {

        it('@cancelClick - should be emitted, when the cancel button is clicked', () => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
                propsData: {
                    tutorial,
                }
            })

            const cancelButton = wrapper.findAll(BaseButton).at(1)
            expect(cancelButton.text()).to.equal('Cancel')
            cancelButton.vm.$emit('click')

            expect(wrapper.emitted().cancelClick.length).to.equal(1)

            expect(wrapper.find(BaseTextField).text()).to.equal('')

            expect(wrapper.find(BaseTextArea).text()).to.equal('')

        })

        it('@saveClick - should be emitted, when the save button is clicked', done => {
            const wrapper = shallowMount(Setting, {
                localVue: Vue,
            })

            const saveButton = wrapper.findAll(BaseButton).at(0)
            expect(saveButton.text()).to.equal('Create')
            saveButton.vm.$emit('click')

            expect(wrapper.emitted().saveClick.length).to.equal(1)

            expect(wrapper.emitted().saveClick[0][0]).to.deep.equal({
                name: '',
                description: '',
            })

            expect(wrapper.find(BaseTextField).text()).to.equal('')

            expect(wrapper.find(BaseTextArea).text()).to.equal('')

            wrapper.setProps({
                tutorial,
            })

            expect(saveButton.text()).to.equal('Save')
            saveButton.vm.$emit('click')

            wrapper.vm.$nextTick(() => {

                expect(wrapper.emitted().saveClick.length).to.equal(2)

                expect(wrapper.emitted().saveClick[1][0]).to.deep.equal(tutorial)

                expect(wrapper.find(BaseTextField).text()).to.equal('')

                expect(wrapper.find(BaseTextArea).text()).to.equal('')

                done()

            })

        })

    })

})