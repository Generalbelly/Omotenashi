import {
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
    SELECT_TUTORIAL,
    SELECT_STEP,
} from './mutation-types'

const state = {
    tutorials: [],
    selectedTutorialId: null,
    selectedStepId: null,
}

export const getters = {
    selectedTutorial: state => {
        if (state.selectedTutorialId) {
            return state.tutorials.find(t => t.id === state.selectedTutorialId)
        }
        return null
    },
    selectedStep:(state, getters) => {
        if (getters.selectedTutorial && state.selectedStepId) {
            return getters.selectedTutorial.steps.find(s => s.id === state.selectedStepId)
        }
        return null
    },
}

export const mutations = {
    [ADD_TUTORIAL](state, tutorial) {
        state.tutorials = [
            ...state.tutorials,
            tutorial,
        ]
        state.selectedTutorialId = tutorial.id
        state.selectedStepId = null
    },
    [UPDATE_TUTORIAL](state, tutorial) {
        const tutorialIndex = state.tutorials.findIndex(t => t.id === tutorial.id)
        state.tutorials = [
            ...state.tutorials.slice(0, tutorialIndex),
            tutorial,
            ...state.tutorials.slice(tutorialIndex+1),
        ]
    },
    [DELETE_TUTORIAL](state, tutorial) {
        state.selectedTutorialId = state.tutorials[0].id

        const tutorialIndex = state.tutorials.findIndex(t => t.id === tutorial.id)
        state.tutorials = [
            ...state.tutorials.slice(0, tutorialIndex),
            ...state.tutorials.slice(tutorialIndex+1),
        ]
    },
    [SELECT_TUTORIAL](state, tutorialId) {
        state.selectedTutorialId = tutorialId
    },
    [SELECT_STEP](state, stepId) {
        state.selectedStepId = stepId
    },
}

export const actions = {
    addTutorial({ commit }, tutorial) {
        commit(ADD_TUTORIAL, tutorial)
    },
    updateTutorial({ commit }, tutorial) {
        commit(UPDATE_TUTORIAL, tutorial)
    },
    deleteTutorial({ commit }, tutorial) {
        commit(DELETE_TUTORIAL, tutorial)
    },
    selectTutorial({ commit }, tutorialId) {
        commit(SELECT_TUTORIAL, tutorialId)
        commit(SELECT_STEP, null)
    },
    addStep({ commit, getters }, step) {
        commit(UPDATE_TUTORIAL, {
            ...getters.selectedTutorial,
            steps: [
                ...getters.selectedTutorial.steps,
                step,
            ]
        })
        commit(SELECT_STEP, step.id)
    },
    updateStep({ commit, getters, state }, step) {
        const stepIndex = getters.selectedTutorial.steps.findIndex(s => s.id === step.id)
        commit(UPDATE_TUTORIAL, {
            ...getters.selectedTutorial,
            steps: [
                ...getters.selectedTutorial.steps.slice(0, stepIndex),
                step,
                ...getters.selectedTutorial.steps.slice(stepIndex+1),
            ],
        })
    },
    deleteStep({ commit, getters, state }, step) {
        const stepIndex = getters.selectedTutorial.steps.findIndex(s => s.id === step.id)
        commit(UPDATE_TUTORIAL, {
            ...getters.selectedTutorial,
            steps: [
                ...getters.selectedTutorial.steps.slice(0, stepIndex),
                ...getters.selectedTutorial.steps.slice(stepIndex+1),
            ],
        })
    },
    selectStep({ commit }, stepId) {
        commit(SELECT_STEP, stepId)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}