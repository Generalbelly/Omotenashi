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

    REDIRECT_TUTORIAL,
    REQUEST_REDIRECT_TUTORIAL,
    REQUEST_REDIRECT_TUTORIAL_SUCCESS,
    REQUEST_REDIRECT_TUTORIAL_FAILURE,

    SET_ERROR_CODE,
} from '../mutation-types'

import TutorialEntity from "../../components/atoms/Entities/TutorialEntity";

const state = {
    total: null,
    tutorialEntity: new TutorialEntity(),
    tutorialEntities: [],
    requestState: null,
}

const getters = {
    isRequesting(state) {
        return state.requestState != null && !/(FAILURE|SUCCESS)$/.exec(state.requestState);
    },
};

export const mutations = {
    [LIST_TUTORIALS](state, payload) {
        const { total, entities } = payload
        state.total = total
        state.tutorialEntities = entities.map(entity => new TutorialEntity(entity));
        state.tutorialEntity = new TutorialEntity()
    },
    [ADD_TUTORIAL](state, payload) {
        const { data } = payload
        const tutorialEntity = new TutorialEntity(data)
        state.tutorialEntity = tutorialEntity
        state.tutorialEntities = [
            ...state.tutorialEntities,
            tutorialEntity,
        ]
    },
    [UPDATE_TUTORIAL](state, payload) {
        const { id, data } = payload
        const tutorialEntity = new TutorialEntity({
            id,
            ...data
        })
        state.tutorialEntity = tutorialEntity
        const tutorialIndex = state.tutorialEntities.findIndex(p => p.id === id)
        if (tutorialIndex !== -1) {
            state.tutorialEntities = [
                ...state.tutorialEntities.slice(0, tutorialIndex),
                tutorialEntity,
                ...state.tutorialEntities.slice(tutorialIndex+1),
            ]
        }
    },
    [DELETE_TUTORIAL](state, payload) {
        const { id } = payload
        const tutorialIndex = state.tutorialEntities.findIndex(p => p.id === id)
        if (tutorialIndex !== -1) {
            state.tutorialEntities = [
                ...state.tutorialEntities.slice(0, tutorialIndex),
                ...state.tutorialEntities.slice(tutorialIndex + 1),
            ]
        }
        this.tutorialEntity = null
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
    [REQUEST_REDIRECT_TUTORIAL](state) {
        state.requestState = REQUEST_REDIRECT_TUTORIAL
    },
    [REQUEST_REDIRECT_TUTORIAL_SUCCESS](state) {
        state.requestState = REQUEST_REDIRECT_TUTORIAL_SUCCESS
    },
    [REQUEST_REDIRECT_TUTORIAL_FAILURE](state, payload) {
        state.requestState = REQUEST_REDIRECT_TUTORIAL_FAILURE
    },
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
        const { pagination={}, q=null, projectId=null } = payload;
        dispatch('request', {
            mutationType: LIST_TUTORIALS,
            projectId,
            params: {
                orderBy: pagination.orderBy,
                q,
            }
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_TUTORIALS_SUCCESS)
                commit(LIST_TUTORIALS, {
                    total: data.total,
                    entities: data.entities,
                })
            })
            .catch((error) => {
                commit(REQUEST_LIST_TUTORIALS_FAILURE, error)
            })
    },
    addTutorial({ commit, dispatch }, payload={}) {
        const { data, projectId=null } = payload
        commit(REQUEST_ADD_TUTORIAL)
        return new Promise(resolve => {
            dispatch('request', {
                data,
                projectId,
                mutationType: ADD_TUTORIAL,
            })
                .then((response) => {
                    const { data } = response
                    commit(REQUEST_ADD_TUTORIAL_SUCCESS)
                    commit(ADD_TUTORIAL, {
                        data
                    })
                    resolve(response)
                })
                .catch((error) => {
                    commit(REQUEST_ADD_TUTORIAL_FAILURE, error)
                })
        })
    },
    updateTutorial({ commit, dispatch }, payload={}) {
        const { data, projectId, id } = payload
        commit(REQUEST_UPDATE_TUTORIAL)
        dispatch('request', {
            data,
            projectId,
            id,
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
    deleteTutorial({ commit, dispatch }, payload={}) {
        const {  projectId, id } = payload
        commit(REQUEST_DELETE_TUTORIAL)
        return new Promise(resolve => {
            dispatch('request', {
                projectId,
                id,
                mutationType: DELETE_TUTORIAL,
            })
                .then((response) => {
                    const { data } = response
                    commit(REQUEST_DELETE_TUTORIAL_SUCCESS)
                    commit(DELETE_TUTORIAL, {
                        id: data.id
                    })
                    resolve(response);
                })
                .catch(() => {
                    commit(REQUEST_DELETE_TUTORIAL_FAILURE)
                })
        });
    },
    redirectTutorial({ commit, dispatch }, payload={}) {
        const {  projectId, id=null } = payload
        commit(REQUEST_REDIRECT_TUTORIAL)
        return new Promise(resolve => {
            dispatch('request', {
                projectId,
                id,
                mutationType: REDIRECT_TUTORIAL,
            })
                .then((response) => {
                    commit(REQUEST_REDIRECT_TUTORIAL_SUCCESS)
                    resolve(response);
                })
                .catch(() => {
                    commit(REQUEST_REDIRECT_TUTORIAL_FAILURE)
                })
        });
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}