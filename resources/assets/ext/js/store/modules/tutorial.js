import {
    makeRequest
} from '../../api'

import {
    GET_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
    SELECT_TUTORIAL,

    ADD_STEP,
    UPDATE_STEP,
    DELETE_STEP,
    SELECT_STEP,

    REQUEST_GET_TUTORIALS,
    REQUEST_GET_TUTORIALS_SUCCESS,
    REQUEST_GET_TUTORIALS_FAILURE,

    REQUEST_ADD_TUTORIAL,
    REQUEST_ADD_TUTORIAL_SUCCESS,
    REQUEST_ADD_TUTORIAL_FAILURE,

    REQUEST_UPDATE_TUTORIAL,
    REQUEST_UPDATE_TUTORIAL_SUCCESS,
    REQUEST_UPDATE_TUTORIAL_FAILURE,

    REQUEST_DELETE_TUTORIAL,
    REQUEST_DELETE_TUTORIAL_SUCCESS,
    REQUEST_DELETE_TUTORIAL_FAILURE,
} from '../mutation-types'

const state = {
    total: null,
    start: null,
    end: null,
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
    [GET_TUTORIALS](state, { total, start, end, entities }) {
        state.total = total;
        state.start = start;
        state.end = end;
        state.tutorials = entities;
    },
    [ADD_TUTORIAL](state, { data }) {
        state.tutorials = [
            ...state.tutorials,
            data,
        ]
    },
    [UPDATE_TUTORIAL](state, { id, data }) {
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
        const tutorialIndex = state.tutorials.findIndex(t => t.id === id)
        state.tutorials = [
            ...state.tutorials.slice(0, tutorialIndex),
            ...state.tutorials.slice(tutorialIndex+1),
        ]
    },
    [REQUEST_GET_TUTORIALS](state) {
        state.isRequesting = REQUEST_GET_TUTORIALS;
    },
    [REQUEST_GET_TUTORIALS_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_GET_TUTORIALS_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_ADD_TUTORIAL](state) {
        state.isRequesting = REQUEST_ADD_TUTORIAL
    },
    [REQUEST_ADD_TUTORIAL_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_ADD_TUTORIAL_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_UPDATE_TUTORIAL](state) {
        state.isRequesting = REQUEST_UPDATE_TUTORIAL
    },
    [REQUEST_UPDATE_TUTORIAL_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_UPDATE_TUTORIAL_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_DELETE_TUTORIAL](state) {
        state.isRequesting = REQUEST_DELETE_TUTORIAL
    },
    [REQUEST_DELETE_TUTORIAL_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_DELETE_TUTORIAL_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [ADD_STEP](state, { data }) {

    },
    [UPDATE_STEP](state, {id, data}) {

    },
    [DELETE_STEP](state, { id }) {

    },
    [SELECT_TUTORIAL](state, { id = null }) {
        if (id) {
            state.selectedTutorialId = id
        } else {
            state.selectedTutorialId = state.tutorials.length > 0 ? state.tutorials[state.tutorials.length - 1] : null;
        }
    },
    [SELECT_STEP](state, { id }) {
        state.selectedStepId = id
    },
}

export const actions = {
    getTutorials({ commit }, { data }) {
        commit(REQUEST_GET_TUTORIALS)
        makeRequest({
            mutationType: REQUEST_GET_TUTORIALS,
            data,
        })
            .then(({ data }) => {
                commit(REQUEST_GET_TUTORIALS_SUCCESS)
                const {
                    total,
                    start,
                    end,
                    entities,
                } = data
                commit(GET_TUTORIALS, {
                    total,
                    start,
                    end,
                    entities,
                })

                if (entities.length > 0) {
                    const firstTutorial = entities[0]
                    const firstTutorialSteps = firstTutorial.steps[0]
                    commit(SELECT_TUTORIAL, {
                        id: firstTutorial.id,
                    })
                    commit(SELECT_STEP, {
                        id: firstTutorialSteps.length > 0 ? firstTutorialSteps[0].id : null
                    })
                }
            })
            .catch((error) => {
                commit(REQUEST_GET_TUTORIALS_FAILURE, error)
            });
    },
    addTutorial({ commit }, { data }) {
        commit(REQUEST_ADD_TUTORIAL)
        makeRequest({
            data,
            mutationType: ADD_TUTORIAL,
        })
            .then(({ data }) => {
                commit(REQUEST_ADD_TUTORIAL_SUCCESS)
                commit(ADD_TUTORIAL, { data })
                commit(SELECT_TUTORIAL, {
                    id: data.id
                })
                commit(SELECT_STEP, { id: null })
            })
            .catch((error) => {
                commit(REQUEST_ADD_TUTORIAL_FAILURE, error)
            })
    },
    updateTutorial({ commit }, { id, data }) {
        commit(REQUEST_UPDATE_TUTORIAL)
        makeRequest({
            id,
            data,
            mutationType: UPDATE_TUTORIAL,
        })
            .then(({ data }) => {
                commit(REQUEST_UPDATE_TUTORIAL_SUCCESS)
                commit(UPDATE_TUTORIAL, {
                    id: data.id,
                    data,
                })
                commit(SELECT_TUTORIAL, {
                    id: data.id
                })
                commit(SELECT_STEP, { id: null })
            })
            .catch(() => {
                commit(REQUEST_UPDATE_TUTORIAL_FAILURE)
            })
    },
    deleteTutorial({ commit }, { id }) {
        commit(REQUEST_DELETE_TUTORIAL)
        makeRequest({
            id,
            mutationType: DELETE_TUTORIAL,
        })
            .then(({ data }) => {
                commit(REQUEST_DELETE_TUTORIAL_SUCCESS)
                commit(DELETE_TUTORIAL, {
                    id: data.id
                })
                commit(SELECT_TUTORIAL, {
                    id: null
                })
                commit(SELECT_STEP, { id: null })
            })
            .catch(() => {
                commit(REQUEST_DELETE_TUTORIAL_FAILURE)
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