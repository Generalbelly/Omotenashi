import {
    makeRequest
} from '../../api/tutorial'

import {
    LIST_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
    SELECT_TUTORIAL,

    SELECT_STEP,

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

    PROJECT_NOT_FOUND,
    SET_ERROR_CODE
} from '../mutation-types'

import TutorialEntity from "../../../../js/components/atoms/Entities/TutorialEntity"
import ProjectEntity from "../../../../js/components/atoms/Entities/ProjectEntity"

const state = {
    projectEntity: null,
    total: null,
    tutorialEntities: [],
    selectedTutorialId: null,
    selectedStepId: null,
    requestState: null,
    projectNotFound: false,
}

export const getters = {
    selectedTutorial: state => {
        if (state.selectedTutorialId) {
            return state.tutorialEntities.find(t => t.id === state.selectedTutorialId)
        }
        return null
    },
    selectedStep:(state, getters) => {
        if (getters.selectedTutorial && state.selectedStepId) {
            return getters.selectedTutorial.steps.find(s => s.id === state.selectedStepId)
        }
        return null
    },
    isRequesting(state) {
        return state.requestState != null && !/(FAILURE|SUCCESS)$/.exec(state.requestState);
    },
}

export const mutations = {
    [LIST_TUTORIALS](state, payload) {
        const { total, start, end, tutorialEntities, projectEntity } = payload
        state.projectEntity = new ProjectEntity(projectEntity)
        state.total = total
        state.tutorialEntities = tutorialEntities.map(tutorialEntity => new TutorialEntity(tutorialEntity))
    },
    [ADD_TUTORIAL](state, { data }) {
        state.tutorialEntities = [
            ...state.tutorialEntities,
            new TutorialEntity(data),
        ]
    },
    [UPDATE_TUTORIAL](state, { id, data }) {
        const tutorialIndex = state.tutorialEntities.findIndex(t => t.id === id)
        state.tutorialEntities = [
            ...state.tutorialEntities.slice(0, tutorialIndex),
            new TutorialEntity({
                id,
                ...data
            }),
            ...state.tutorialEntities.slice(tutorialIndex+1),
        ]
    },
    [DELETE_TUTORIAL](state, payload) {
        const { id } = payload
        const tutorialIndex = state.tutorialEntities.findIndex(t => t.id === id)
        state.tutorialEntities = [
            ...state.tutorialEntities.slice(0, tutorialIndex),
            ...state.tutorialEntities.slice(tutorialIndex+1),
        ]
    },
    [REQUEST_LIST_TUTORIALS](state) {
        state.requestState = REQUEST_LIST_TUTORIALS
    },
    [REQUEST_LIST_TUTORIALS_SUCCESS](state) {
        state.requestState = REQUEST_LIST_TUTORIALS_SUCCESS
    },
    [REQUEST_LIST_TUTORIALS_FAILURE](state, payload) {
        state.requestState = REQUEST_LIST_TUTORIALS_FAILURE
    },
    [REQUEST_ADD_TUTORIAL](state) {
        state.requestState = REQUEST_ADD_TUTORIAL
    },
    [REQUEST_ADD_TUTORIAL_SUCCESS](state) {
        state.requestState = REQUEST_ADD_TUTORIAL_SUCCESS
    },
    [REQUEST_ADD_TUTORIAL_FAILURE](state, payload) {
        state.requestState = REQUEST_ADD_TUTORIAL_FAILURE
    },
    [REQUEST_UPDATE_TUTORIAL](state) {
        state.requestState = REQUEST_UPDATE_TUTORIAL
    },
    [REQUEST_UPDATE_TUTORIAL_SUCCESS](state) {
        state.requestState = REQUEST_UPDATE_TUTORIAL_SUCCESS
    },
    [REQUEST_UPDATE_TUTORIAL_FAILURE](state, payload) {
        state.requestState = REQUEST_UPDATE_TUTORIAL_FAILURE
    },
    [REQUEST_DELETE_TUTORIAL](state) {
        state.requestState = REQUEST_DELETE_TUTORIAL
    },
    [REQUEST_DELETE_TUTORIAL_SUCCESS](state) {
        state.requestState = REQUEST_DELETE_TUTORIAL_SUCCESS
    },
    [REQUEST_DELETE_TUTORIAL_FAILURE](state, payload) {
        state.requestState = REQUEST_DELETE_TUTORIAL_FAILURE
    },
    [SELECT_TUTORIAL](state, { id = null }) {
        if (id) {
            state.selectedTutorialId = id
        } else {
            state.selectedTutorialId = state.tutorialEntities.length > 0 ? state.tutorialEntities[state.tutorialEntities.length - 1] : null;
        }
    },
    [SELECT_STEP](state, { id }) {
        state.selectedStepId = id
    },
    [PROJECT_NOT_FOUND](state, shouldShow) {
        state.projectNotFound = shouldShow
    }
}

export const actions = {
    request({ commit }, payload) {
        return new Promise((resolve, reject) => {
            makeRequest(payload)
                .then(response => {
                    resolve(response);
                })
                .catch((error) => {
                    const {
                        response = null
                    } = error;
                    if (response) {
                        commit(SET_ERROR_CODE, response.status, { root: true })
                    }
                    reject(error);
                })
        })
    },
    listTutorials({ commit, dispatch }, payload={}) {
        commit(REQUEST_LIST_TUTORIALS)
        const { pagination={}, q=null, origin=window.location.origin } = payload;
        dispatch('request', {
            mutationType: LIST_TUTORIALS,
            params: {
                orderBy: pagination.orderBy,
                origin,
                q,
            }
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_TUTORIALS_SUCCESS)
                commit(LIST_TUTORIALS, data)
                commit(PROJECT_NOT_FOUND, false)
            })
            .catch((error) => {
            commit(REQUEST_LIST_TUTORIALS_FAILURE, error)
            const {
                data={}
            } = error.response;
            if (data.error && data.error.type === 'ProjectNotFound') {
                commit(PROJECT_NOT_FOUND, true);
            }
        })
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
                // commit(SELECT_TUTORIAL, {
                //     id: data.id
                // })
                // commit(SELECT_STEP, { id: null })
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
    addStep({ commit, getters, dispatch, state }, { data }) {
        dispatch('updateTutorial', {
            id: getters.selectedTutorial.id,
            data: {
                ...getters.selectedTutorial,
                steps: [
                    ...getters.selectedTutorial.steps,
                    data,
                ],
                project_id: state.projectEntity.id,
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