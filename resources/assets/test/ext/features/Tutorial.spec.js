import {
    shallowMount,
    createLocalVue,
    mount
} from '@vue/test-utils'
import Vuex from 'vuex'
import Tutorial, {
    userActions,
    messageKeys
} from '../../../ext/js/features/Tutorial'
import Menu from '../../../ext/js/components/Tutorial/Menu'
import DeleteConfirmationMessage from '../../../ext/js/components/Tutorial/DeleteConfirmationMessage'
import Setting from '../../../ext/js/components/Tutorial/Setting'
import BaseMessage from '../../../ext/js/components/BaseMessage'
import tutorial from "../../../ext/js/store/modules/tutorial";

const localVue = createLocalVue()
localVue.use(Vuex)

describe('Tutorial.vue', () => {

    const tutorials = [
        {
            id: '953c909a-e446-43fb-aea2-e07fa29716e9',
            name: 'Awesome Tutorial',
            description: 'This tutorial is awesome.',
            steps: [
                {
                    id: '383c930a-e446-21fb-aea3-e07fa29716e3',
                    element: '.flex .flex > .primary > .btn__content',
                    popover: {
                        content: '<div><h1>Title</h1><div>Some description here</div></div>',
                    }
                },
                {
                    id: '283c930a-e339-00fb-aea2-e07fa29716e4',
                    element: '.flex .flex > .primary > .btn__content',
                    popover: {
                        content: '<div><h1>Title</h1><div>Some description here</div></div>',
                    }
                }
            ],
        },
        {
            id: '953c690c-e446-32fb-aea2-e07fa29716e8',
            name: 'OK Tutorial',
            description: 'This tutorial is okay.',
            steps: [],
        },
        {
            id: '888c909a-e323-13fb-aea2-e07fa29316e7',
            name: 'Bad tutorial',
            description: 'This tutorial is bad.',
            steps: [],
        }
    ];

    let store
    let actions
    let tutorialActions

    beforeEach(() => {
        actions = {
            retrieveLog: sinon.fake(),
            saveLog: sinon.fake(),
        }

        tutorialActions = {
            addTutorial: sinon.fake.returns(() => {}),
            updateTutorial: sinon.fake(),
            deleteTutorial: sinon.fake(),
            selectTutorial: sinon.fake(),
            selectStep: sinon.fake(),
            addStep: sinon.fake(),
            updateStep: sinon.fake(),
            deleteStep: sinon.fake(),
        }

        store = new Vuex.Store({
            namespaced: false,
            state: {
                extLog: {
                    userIsFirstTime: false,
                    checkedMessages: [],
                }
            },
            actions,
            getters: {},
            modules: {
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

            setting.vm.$emit('saveClick', tutorial);
            expect(menu.isVisible()).to.equal(true)
            expect(setting.isVisible()).to.equal(false)

        })

        it('DeleteCOnfirmationMessage - should be shown when either isDeletingTutorial is true', () => {

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

        it('BaseMessage - should be shown depending on the value of shownMessage', () => {

            const wrapper = shallowMount(Tutorial, {
                localVue,
                store,
            })

            const messages = wrapper.findAll(BaseMessage)

            const selectorChoicesAvailable = messages.filter(w => w.text().includes('please keep clicking until you find the right one.')).at(0)
            const noStepAddedYet = messages.filter(w => w.props().body.includes('You haven\'t added any step yet.')).at(0)
            const noMoreSelectorChoices = messages.filter(w => w.props().body.includes('Looks like we don\'t have any other elements to show you.')).at(0)
            const clickToAddStep = messages.filter(w => w.props().body.includes('Click anywhere you want to attract your user attention.')).at(0)

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

    })
})