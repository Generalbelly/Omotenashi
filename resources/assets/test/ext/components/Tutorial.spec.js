// import {
//     shallowMount,
//     createLocalVue
// } from '@vue/test-utils'
// import Vuex from 'vuex'
// import Tutorial from '../../../ext/js/features/Tutorial'
//
// const localVue = createLocalVue()
// localVue.use(Vuex)
//
// describe('Tutorial.vue', () => {
//     let store
//     beforeEach(() => {
//         store = new Vuex.Store({
//             namespaced: false,
//             state: {
//                 extLog: {
//                     userIsFirstTime: false,
//                     checkedMessages: [],
//                 }
//             },
//             actions: {
//                 retrieveLog: sinon.fake(),
//                 saveLog: sinon.fake(),
//             },
//             getters: {},
//             modules: {
//                 tutorial: {
//                     namespaced: true,
//                     state: {
//                         tutorials: [],
//                         selectedTutorialId: null,
//                         selectedStepId: null
//                     },
//                     actions: {
//                         addTutorial: sinon.fake(),
//                         updateTutorial: sinon.fake(),
//                         deleteTutorial: sinon.fake(),
//                         selectTutorial: sinon.fake(),
//                         selectStep: sinon.fake(),
//                         addStep: sinon.fake(),
//                         updateStep: sinon.fake(),
//                         deleteStep: sinon.fake()
//                     },
//                     getters: {
//                         selectedTutorial: () => null,
//                         selectedStep: () => null
//                     }
//                 }
//             }
//         })
//     })
//
//     describe('@eventss', () => {
//         it('@homeClick - should emit an "homeclick" event when the home button is clicked', () => {
//             const wrapper = shallowMount(Tutorial, { store, localVue })
//             wrapper.vm.$emit('homeClick')
//             expect(wrapper.emitted().homeClick).to.have.lengthOf(1)
//         })
//     })
// })