import {
    makeRequest
} from '../../api/tutorial'

import {
    LIST_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,

    REQUEST_LIST_TUTORIALS,
    REQUEST_LIST_TUTORIALS_SUCCESS,
    REQUEST_LIST_TUTORIALS_FAILURE,

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
    tutorials: [],
    isRequesting: false,
}

export const getters = {}

export const mutations = {
    [LIST_TUTORIALS](state, { total, entities }) {
        state.total = total;
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
    [REQUEST_LIST_TUTORIALS](state) {
        state.isRequesting = REQUEST_LIST_TUTORIALS;
    },
    [REQUEST_LIST_TUTORIALS_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_LIST_TUTORIALS_FAILURE](state, { errorCode, errorMsg }) {
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
}

export const actions = {
    listTutorials({ commit }, { data }) {
        commit(REQUEST_LIST_TUTORIALS)
        makeRequest({
            mutationType: LIST_TUTORIALS,
            data,
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_TUTORIALS_SUCCESS)
                const {
                    total,
                    entities,
                } = data
                commit(LIST_TUTORIALS, {
                    total,
                    entities,
                })

            })
            .catch((error) => {
                commit(REQUEST_LIST_TUTORIALS_FAILURE, error)
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
            })
            .catch(() => {
                commit(REQUEST_DELETE_TUTORIAL_FAILURE)
            })
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}