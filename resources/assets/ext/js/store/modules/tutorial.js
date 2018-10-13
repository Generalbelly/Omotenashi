import {
    makeRequest
} from '../../api'

import {
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
    SELECT_TUTORIAL,

    ADD_STEP,
    UPDATE_STEP,
    DELETE_STEP,
    SELECT_STEP,

    REQUEST_ADD_TUTORIAL,
    REQUEST_ADD_TUTORIAL_SUCCESS,
    REQUEST_ADD_TUTORIAL_FAILURE,
    REQUEST_UPDATE_TUTORIAL,
    REQUEST_DELETE_TUTORIAL,
} from '../mutation-types'

const state = {
    tutorials: [],
    selectedTutorialId: null,
    selectedStepId: null,
    isRequesting: false,
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
    [ADD_TUTORIAL](state, { id, ...data }) {
        state.tutorials = [
            ...state.tutorials,
            {
                id,
                ...data
            },
        ]
    },
    [UPDATE_TUTORIAL](state, { id, ...data }) {
        const tutorialIndex = state.tutorials.findIndex(t => t.id === id)
        state.tutorials = [
            ...state.tutorials.slice(0, tutorialIndex),
            {
                id,
                ...data
            },
            ...state.tutorials.slice(tutorialIndex+1),
        ]
    },
    [DELETE_TUTORIAL](state, { id }) {
        state.selectedTutorialId = state.tutorials.length > 0 ? state.tutorials[0].id : null;

        const tutorialIndex = state.tutorials.findIndex(t => t.id === id)
        state.tutorials = [
            ...state.tutorials.slice(0, tutorialIndex),
            ...state.tutorials.slice(tutorialIndex+1),
        ]
    },
    [REQUEST_ADD_TUTORIAL](state) {
        state.isRequesting = true
    },
    [REQUEST_ADD_TUTORIAL_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_ADD_TUTORIAL_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [ADD_STEP](state, { data }) {

    },
    [UPDATE_STEP](state, {id, data}) {

    },
    [DELETE_STEP](state, { id }) {

    },
    [SELECT_TUTORIAL](state, { id }) {
        state.selectedTutorialId = id
    },
    [SELECT_STEP](state, { id }) {
        state.selectedStepId = id
    },
}

export const actions = {
    addTutorial({ commit }, { data }) {
        commit(REQUEST_ADD_TUTORIAL)
        makeRequest({
            data,
            mutationType: ADD_TUTORIAL,
        })
            .then((data) => {
                commit(REQUEST_ADD_TUTORIAL_SUCCESS)
                commit(ADD_TUTORIAL, data)
                commit(SELECT_TUTORIAL, { id: data.id })
                commit(SELECT_STEP, { id: null })
            })
            .catch((error) => {
                commit(REQUEST_ADD_TUTORIAL_FAILURE, error)
            })
    },
    updateTutorial({ commit }, { id, data }) {
        // commit(REQUEST_UPDATE_TUTORIAL)
        makeRequest({
            id,
            data,
            mutationType: UPDATE_TUTORIAL,
        })
            .then((data) => {
                // commit(REQUEST_ADD_TUTORIAL_SUCCESS)
                commit(UPDATE_TUTORIAL, data)
            })
            .catch(() => {
                // commit(REQUEST_ADD_TUTORIAL_FAILURE)
            })
    },
    deleteTutorial({ commit }, { id }) {
        // commit(REQUEST_DELETE_TUTORIAL)
        makeRequest({
            id,
            mutationType: DELETE_TUTORIAL,
        })
            .then((data) => {
                // commit(REQUEST_DELETE_TUTORIAL_SUCCESS)
                commit(DELETE_TUTORIAL, { id })
            })
            .catch(() => {
                // commit(REQUEST_DELETE_TUTORIAL_FAILURE)
            })
    },
    selectTutorial({ commit }, { id }) {
        commit(SELECT_TUTORIAL, { id })
        commit(SELECT_STEP, { id: null })
    },
    addStep({ commit, getters, dispatch }, { data }) {
        dispatch('updateTutorial', {
            id: getters.selectedTutorial.id,
            data: {
                ...getters.selectedTutorial,
                steps: [
                    ...getters.selectedTutorial.steps,
                    data,
                ]
            },
        })
    },
    updateStep({ commit, getters, dispatch }, { id, data }) {
        const stepIndex = getters.selectedTutorial.steps.findIndex(s => s.id === id)
        dispatch('updateTutorial', {
            id: getters.selectedTutorial.id,
            data: {
                ...getters.selectedTutorial,
                steps: [
                    ...getters.selectedTutorial.steps.slice(0, stepIndex),
                    data,
                    ...getters.selectedTutorial.steps.slice(stepIndex+1),
                ],
            },
        })
    },
    deleteStep({ commit, getters, dispatch }, { id }) {
        const stepIndex = getters.selectedTutorial.steps.findIndex(s => s.id === id)
        dispatch('updateTutorial', {
            id: getters.selectedTutorial.id,
            data: {
                ...getters.selectedTutorial,
                steps: [
                    ...getters.selectedTutorial.steps.slice(0, stepIndex),
                    ...getters.selectedTutorial.steps.slice(stepIndex+1),
                ],
            },
        })
    },
    selectStep({ commit }, { id }) {
        commit(SELECT_STEP, { id })
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}