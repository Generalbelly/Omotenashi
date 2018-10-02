import {
    shallowMount,
    createLocalVue,
    mount
} from '@vue/test-utils'
import Vuex from 'vuex'
import Tutorial, {
    userActions,
    messageKeys
} from '../../../ext/js/components/pages/Tutorial'
import BaseButton from '../../../ext/js/components/atoms/BaseButton'
import Menu from '../../../ext/js/components/organisms/Menu'
import DeleteConfirmationMessage from '../../../ext/js/components/organisms/DeleteConfirmationMessage'
import Setting from '../../../ext/js/components/organisms/Setting'
import HelpMessage from '../../../ext/js/components/molecules/Message'
import { tutorials } from "../mock";

const localVue = createLocalVue()
localVue.use(Vuex)

describe('Tutorial.vue', () => {

    let store
    let actions
    let tutorialActions
    let selectedTutorial
    let selectedStep

    let state
    let modules

    beforeEach(() => {
        selectedTutorial = tutorials[0]
        selectedStep = tutorials[0].steps[0]
        state = {
            extLog: {
                userIsFirstTime: false,
                checkedMessages: [],
            }
        }
        actions = {
            retrieveLog: sinon.fake(),
            saveLog: sinon.fake(),
        }

        tutorialActions = {
            addTutorial: sinon.fake(),
            updateTutorial: sinon.fake(),
            deleteTutorial: sinon.fake(),
            selectTutorial: sinon.fake(),
            selectStep: sinon.fake(),
            addStep: sinon.fake(),
            updateStep: sinon.fake(),
            deleteStep: sinon.fake(),
        }

        modules = {
            tutorial: {
                namespaced: true,
                state: {
                    tutorials: [],
                    selectedTutorialId: null,
                    selectedStepId: null
                },
                getters: {
                    selectedTutorial: () => null,
                    selectedStep: () => null
                },
                actions: tutorialActions,
            }
        }

        store = new Vuex.Store({
            namespaced: false,
            getters: {},
            state,
            actions,
            modules,
        })
    })

    describe('@events', () => {

        it('@homeClick - should be emitted when the "homeClick" event is emitted from Menu component', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })
            const menu = wrapper.find(Menu)
            menu.vm.$emit('homeClick')
            expect(wrapper.emitted().homeClick.length).to.equal(1)
        })

    })

    describe('life cycle', () => {

        it('created() - new driver object is created and a new tutorial is added if there is none of them.', done => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            // TODO:: 本当はaddEventListnerのところもてすとしたい
            expect(wrapper.vm.$data.driver).not.to.equal(null)

            wrapper.vm.$nextTick(() => {
                expect(tutorialActions.addTutorial.callCount).equal(1)
                done()
            })
        })

        it('destroyed() - driver is set to null.', done => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            wrapper.destroy()
            // TODO:: 本当はremoveEventListnerのところもてすとしたい
            wrapper.vm.$nextTick(() => {
                expect(wrapper.vm.$data.driver).to.equal(null)
                done()
            })
        })

    })

    describe('computed methods', () => {

        it('userAction - should be accessible by computed property', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            Object.values(userActions).forEach(action => {
                const name = `is${action.charAt(0).toUpperCase() + action.substr(1)}`
                expect(wrapper.vm).to.have.property(name)
            })
        })

        it('messageShown - should be accessible by computed property', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            Object.values(messageKeys).forEach(messageKey => {
                const name = `${messageKey}MessageShown`
                expect(wrapper.vm).to.have.property(name)
            })
        })
    })

    describe('user interactions', () => {

        it('Menu - should be shown when the user action is on menu.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)

            expect(menu.isVisible()).to.equal(true)

            menu.vm.$emit('addTutorialClick')

            expect(wrapper.vm.$data.userAction).to.equal(userActions.addingTutorial)
            expect(menu.isVisible()).to.equal(false)

        })

        it('Menu - should be positioned based on the value of menuIsOnTheRight.', () => {
            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)

            expect(menu.classes().includes('is-fixed-bottom-right')).to.equal(true)
            expect(menu.classes().includes('is-fixed-bottom-left')).to.equal(false)

            menu.vm.$emit('switchSideClick')

            expect(menu.classes().includes('is-fixed-bottom-left')).to.equal(true)
            expect(menu.classes().includes('is-fixed-bottom-right')).to.equal(false)

        })

        it('Setting - should be shown when either isAddingTutorial or isEditingTUtorial is true', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            const setting = wrapper.find(Setting)

            expect(menu.isVisible()).to.equal(true)
            expect(setting.isVisible()).to.equal(false)

            menu.vm.$emit('addTutorialClick')

            expect(wrapper.vm.$data.userAction).to.equal(userActions.addingTutorial)
            expect(menu.isVisible()).to.equal(false)
            expect(setting.isVisible()).to.equal(true)

            setting.vm.$emit('cancelClick')

            expect(menu.isVisible()).to.equal(true)
            expect(setting.isVisible()).to.equal(false)

            menu.vm.$emit('editTutorialClick')

            expect(wrapper.vm.$data.userAction).to.equal(userActions.editingTutorial)
            expect(menu.isVisible()).to.equal(false)
            expect(setting.isVisible()).to.equal(true)

            setting.vm.$emit('saveClick', tutorials[0]);
            expect(menu.isVisible()).to.equal(true)
            expect(setting.isVisible()).to.equal(false)

        })

        it('DeleteConfirmationMessage - should be shown when either isDeletingTutorial is true', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            const deleteConfirmationMessage = wrapper.find(DeleteConfirmationMessage)

            expect(menu.isVisible()).to.equal(true)
            expect(deleteConfirmationMessage.isVisible()).to.equal(false)

            menu.vm.$emit('deleteTutorialClick')

            expect(wrapper.vm.$data.userAction).to.equal(userActions.deletingTutorial)
            expect(menu.isVisible()).to.equal(false)
            expect(deleteConfirmationMessage.isVisible()).to.equal(true)

        })

        it('The Step save and cancel buttons - should be shown when isEditingPopover is true', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const saveCancelButtons = wrapper.find('.step-editing-actions')
            expect(saveCancelButtons.isVisible()).to.equal(false)

            wrapper.setData({
                userAction: userActions.editingPopover
            })

            expect(saveCancelButtons.isVisible()).to.equal(true)

        })

        it('A message - should be shown with depending on the value of shownMessage', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const messages = wrapper.findAll(HelpMessage)

            const selectorChoicesAvailable = messages.filter(w => w.text().includes('please keep clicking until you find the right one.')).at(0)
            const noStepAddedYet = messages.filter(w => w.text().includes('You haven\'t added any step yet.')).at(0)
            const noMoreSelectorChoices = messages.filter(w => w.text().includes('Looks like we don\'t have any other elements to show you.')).at(0)
            const clickToAddStep = messages.filter(w => w.text().includes('Click anywhere you want to attract your user attention.')).at(0)

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)
            expect(noStepAddedYet.isVisible()).to.equal(false)
            expect(noMoreSelectorChoices.isVisible()).to.equal(false)
            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.setData({
                messageShown: messageKeys.selectorChoicesAvailable,
            })

            expect(selectorChoicesAvailable.isVisible()).to.equal(true)
            expect(noStepAddedYet.isVisible()).to.equal(false)
            expect(noMoreSelectorChoices.isVisible()).to.equal(false)
            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.setData({
                messageShown: messageKeys.noStepAddedYet,
            })

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)
            expect(noStepAddedYet.isVisible()).to.equal(true)
            expect(noMoreSelectorChoices.isVisible()).to.equal(false)
            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.setData({
                messageShown: messageKeys.noMoreSelectorChoices,
            })

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)
            expect(noStepAddedYet.isVisible()).to.equal(false)
            expect(noMoreSelectorChoices.isVisible()).to.equal(true)
            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.setData({
                messageShown: messageKeys.clickToAddStep,
            })

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)
            expect(noStepAddedYet.isVisible()).to.equal(false)
            expect(noMoreSelectorChoices.isVisible()).to.equal(false)
            expect(clickToAddStep.isVisible()).to.equal(true)

        })

        it('A selectorChoicesAvailable message - should not be shown when the user checked don\'t show me this message last time he/she saw it.', () => {

            store = new Vuex.Store({
                namespaced: false,
                state: {
                    extLog: {
                        userIsFirstTime: false,
                        checkedMessages: [messageKeys.selectorChoicesAvailable],
                    }
                },
                getters: {},
                actions,
                modules,
            })

            let wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            let messages = wrapper.findAll(HelpMessage)
            let selectorChoicesAvailable = messages.filter(w => w.text().includes('please keep clicking until you find the right one.')).at(0)

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)

            wrapper.vm.showMessage(messageKeys.selectorChoicesAvailable)

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)

            wrapper.destroy()

            store = new Vuex.Store({
                namespaced: false,
                state: {
                    extLog: {
                        userIsFirstTime: false,
                        checkedMessages: [],
                    }
                },
                getters: {},
                actions,
                modules,
            })

            wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            messages = wrapper.findAll(HelpMessage)
            selectorChoicesAvailable = messages.filter(w => w.text().includes('please keep clicking until you find the right one.')).at(0)

            expect(selectorChoicesAvailable.isVisible()).to.equal(false)

            wrapper.vm.showMessage(messageKeys.selectorChoicesAvailable)

            expect(selectorChoicesAvailable.isVisible()).to.equal(true)

        })

        it('A clickToAddStep message - should not be shown when the user checked don\'t show me this message last time he/she saw it.', () => {

            store = new Vuex.Store({
                state: {
                    extLog: {
                        userIsFirstTime: false,
                        checkedMessages: [messageKeys.clickToAddStep],
                    }
                },
                getters: {},
                actions,
                modules,
            })

            let wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            let messages = wrapper.findAll(HelpMessage)

            let clickToAddStep = messages.filter(w => w.text().includes('Click anywhere you want to attract your user attention.')).at(0)

            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.vm.showMessage(messageKeys.clickToAddStep)

            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.destroy()

            store = new Vuex.Store({
                namespaced: false,
                state: {
                    extLog: {
                        userIsFirstTime: false,
                        checkedMessages: [],
                    }
                },
                getters: {},
                actions,
                modules,
            })

            wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            messages = wrapper.findAll(HelpMessage)

            clickToAddStep = messages.filter(w => w.text().includes('Click anywhere you want to attract your user attention.')).at(0)

            expect(clickToAddStep.isVisible()).to.equal(false)

            wrapper.vm.showMessage(messageKeys.clickToAddStep)

            expect(clickToAddStep.isVisible()).to.equal(true)

        })

        it('Vuex action: addTutorial - should be called when it get a saveClick event with tutorial as an argument from Setting', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const { id, withoutId } = tutorials[0]

            const menu = wrapper.find(Menu)
            menu.vm.$emit('saveClick', withoutId)

            expect(tutorialActions.addTutorial.callCount).to.equal(1)

        })

        it('Vuex action: updateTutorial - should be called when it get a saveClick event with tutorial having id as an argument from Setting', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            menu.vm.$emit('saveClick', tutorials[0])

            expect(tutorialActions.addTutorial.callCount).to.equal(1)

        })

        it('Vuex action: deleteTutorial - should be called when it get a deleteClick from DeleteConfirmationMessage component.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(DeleteConfirmationMessage)
            menu.vm.$emit('deleteClick')

            expect(tutorialActions.deleteTutorial.callCount).to.equal(1)

        })

        it('Vuex action: selectTutorial - should be called when it get a tutorialChange event from Menu component.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            menu.vm.$emit('tutorialChange')

            expect(tutorialActions.selectTutorial.callCount).to.equal(1)

        })

        it('Vuex action: addStep - should be called when the step save button is clicked.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
                methods: {
                    createStep: () => {
                        return {
                            element: '',
                            popover: {
                                content: '',
                            }
                        }
                    }
                }
            })

            const stepSaveButton = wrapper.findAll(BaseButton).filter(w => w.text() === 'Save').at(0)
            stepSaveButton.vm.$emit('click')

            expect(tutorialActions.addStep.callCount).to.equal(1)

        })

        it('Vuex action: updateStep - should be called when the step save button is clicked and selectedStepId is not null.', () => {

            store = new Vuex.Store({
                namespaced: false,
                state,
                getters: {},
                actions,
                modules: {
                    tutorial: {
                        namespaced: true,
                        state: {
                            tutorials,
                            selectedTutorialId: selectedTutorial.id,
                            selectedStepId: selectedStep.id,
                        },
                        getters: {
                            selectedTutorial: () => selectedTutorial,
                            selectedStep: () => selectedStep,
                        },
                        actions: tutorialActions,
                    },
                },
            })

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
                methods: {
                    createStep: () => {
                        return {
                            element: '',
                            popover: {
                                content: '',
                            }
                        }
                    }
                }
            })

            const stepSaveButton = wrapper.findAll(BaseButton).filter(w => w.text() === 'Save').at(0)
            stepSaveButton.vm.$emit('click')

            expect(tutorialActions.updateStep.callCount).to.equal(1)

        })

        it('Vuex action: deleteStep - should be called when it get a deleteStepClick event from Menu component.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            menu.vm.$emit('deleteStepClick')

            expect(tutorialActions.deleteStep.callCount).to.equal(1)

        })

        it('Vuex action: selectStep - should be called when it get a stepClick event from Menu component.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            menu.vm.$emit('stepClick', selectedStep)

            expect(tutorialActions.selectStep.callCount).to.equal(1)

        })

        it('Vuex action: selectStep - should be called when it get a addStepClick event from Menu component.', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const menu = wrapper.find(Menu)
            menu.vm.$emit('stepClick', selectedStep)

            expect(tutorialActions.selectStep.callCount).to.equal(1)

        })

        it('Vuex action: selectStep - should be called when highlight method is called with an element argument that is already in steps.', () => {

            store = new Vuex.Store({
                namespaced: false,
                state,
                getters: {},
                actions,
                modules: {
                    tutorial: {
                        namespaced: true,
                        state: {
                            tutorials,
                            selectedTutorialId: selectedTutorial.id,
                            selectedStepId: selectedStep.id,
                        },
                        getters: {
                            selectedTutorial: () => selectedTutorial,
                            selectedStep: () => selectedStep,
                        },
                        actions: tutorialActions,
                    },
                },
            })

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            wrapper.vm.highlight({
                id: null,
                element: selectedStep.element,
            })

            expect(tutorialActions.selectStep.callCount).to.equal(1)

        })

    })
})