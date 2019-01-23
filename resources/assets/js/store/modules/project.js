import {
    makeRequest
} from '../../api/project'

import {
    LIST_PROJECTS,
    ADD_PROJECT,
    GET_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,

    REQUEST_LIST_PROJECTS,
    REQUEST_LIST_PROJECTS_SUCCESS,
    REQUEST_LIST_PROJECTS_FAILURE,

    REQUEST_ADD_PROJECT,
    REQUEST_ADD_PROJECT_SUCCESS,
    REQUEST_ADD_PROJECT_FAILURE,

    REQUEST_GET_PROJECT,
    REQUEST_GET_PROJECT_SUCCESS,
    REQUEST_GET_PROJECT_FAILURE,

    REQUEST_UPDATE_PROJECT,
    REQUEST_UPDATE_PROJECT_SUCCESS,
    REQUEST_UPDATE_PROJECT_FAILURE,

    REQUEST_DELETE_PROJECT,
    REQUEST_DELETE_PROJECT_SUCCESS,
    REQUEST_DELETE_PROJECT_FAILURE,
    SET_ERROR_CODE,
} from '../mutation-types'

import ProjectEntity from "../../components/atoms/Entities/ProjectEntity";

const state = {
    total: null,
    projectEntity: new ProjectEntity(),
    projectEntities: [],
    isRequesting: false,
    requestState: null,
}

export const mutations = {
    [LIST_PROJECTS](state, payload) {
        const { total, entities } = payload
        state.total = total
        state.projectEntities = entities.map(entity => new ProjectEntity(entity));
    },
    [ADD_PROJECT](state, payload) {
        const { data } = payload
        state.projectEntities = [
            ...state.projectEntities,
            data,
        ]
    },
    [UPDATE_PROJECT](state, payload) {
        const { id, data } = payload
        const projectIndex = state.projectEntities.findIndex(t => t.id === id)
        state.projectEntities = [
            ...state.projectEntities.slice(0, projectIndex),
            new ProjectEntity({
                id,
                ...data
            }),
            ...state.projectEntities.slice(projectIndex+1),
        ]
    },
    [DELETE_PROJECT](state, payload) {
        const { id } = payload
        const projectIndex = state.projectEntities.findIndex(t => t.id === id)
        state.projectEntities = [
            ...state.projectEntities.slice(0, projectIndex),
            ...state.projectEntities.slice(projectIndex+1),
        ]
    },
    [REQUEST_LIST_PROJECTS](state) {
        state.isRequesting = true
        state.requestState = REQUEST_LIST_PROJECTS
    },
    [REQUEST_LIST_PROJECTS_SUCCESS](state) {
        state.isRequesting = false
        state.requestState = REQUEST_LIST_PROJECTS_SUCCESS
    },
    [REQUEST_LIST_PROJECTS_FAILURE](state, payload) {
        const { status, data } = payload
        state.isRequesting = false
        state.requestState = REQUEST_LIST_PROJECTS_FAILURE
    },
    [REQUEST_ADD_PROJECT](state) {
        state.isRequesting = true
        state.requestState = REQUEST_ADD_PROJECT
    },
    [REQUEST_ADD_PROJECT_SUCCESS](state) {
        state.isRequesting = false
        state.requestState = REQUEST_ADD_PROJECT_SUCCESS
    },
    [REQUEST_ADD_PROJECT_FAILURE](state, payload) {
        const { status, data } = payload
        state.isRequesting = false
        state.requestState = REQUEST_ADD_PROJECT_FAILURE
    },
    [GET_PROJECT](state, payload) {
        const { data } = payload;
        state.projectEntity = data
    },
    [REQUEST_GET_PROJECT](state) {
        state.isRequesting = true
        state.requestState = REQUEST_GET_PROJECT
    },
    [REQUEST_GET_PROJECT_SUCCESS](state) {
        state.isRequesting = false
        state.requestState = REQUEST_GET_PROJECT_SUCCESS
    },
    [REQUEST_GET_PROJECT_FAILURE](state, payload) {
        const { status, data } = payload
        state.isRequesting = false
        state.requestState = REQUEST_GET_PROJECT_FAILURE
    },
    [REQUEST_UPDATE_PROJECT](state) {
        state.isRequesting = true
        state.requestState = REQUEST_UPDATE_PROJECT
    },
    [REQUEST_UPDATE_PROJECT_SUCCESS](state) {
        state.isRequesting = false
        state.requestState = REQUEST_UPDATE_PROJECT_SUCCESS
    },
    [REQUEST_UPDATE_PROJECT_FAILURE](state, payload) {
        const { status, data } = payload
        state.isRequesting = false
        state.requestState = REQUEST_UPDATE_PROJECT_FAILURE
    },
    [REQUEST_DELETE_PROJECT](state) {
        state.isRequesting = true
        state.requestState = REQUEST_DELETE_PROJECT
    },
    [REQUEST_DELETE_PROJECT_SUCCESS](state) {
        state.isRequesting = false
        state.requestState = REQUEST_DELETE_PROJECT_SUCCESS
    },
    [REQUEST_DELETE_PROJECT_FAILURE](state, payload) {
        const { status, data } = payload
        state.isRequesting = false
        state.requestState = REQUEST_DELETE_PROJECT_FAILURE
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
                    commit(SET_ERROR_CODE, error.response.status, { root: true })
                    reject(error);
                })
        })
    },
    listProjects({ commit, dispatch }, payload={}) {
        commit(REQUEST_LIST_PROJECTS)
        const { pagination={}, q=null, } = payload;
        dispatch('request', {
            mutationType: LIST_PROJECTS,
            params: {
                orderBy: pagination.orderBy,
                q,
            }
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_PROJECTS_SUCCESS)
                commit(LIST_PROJECTS, {
                    total: data.total,
                    entities: data.entities,
                })
            })
            .catch((error) => {
                commit(REQUEST_LIST_PROJECTS_FAILURE, error)
            })
    },
    addProject({ commit, dispatch }, payload={}) {
        const { data } = payload
        commit(REQUEST_ADD_PROJECT)
        dispatch('request', {
            data,
            mutationType: ADD_PROJECT,
        })
            .then(({ data }) => {
                commit(REQUEST_ADD_PROJECT_SUCCESS)
                commit(ADD_PROJECT, {
                    data
                })
            })
            .catch((error) => {
                commit(REQUEST_ADD_PROJECT_FAILURE, error)
            })
    },
    getProject({ commit, dispatch }, payload={}) {
        const { id } = payload
        if (id) {
            commit(REQUEST_GET_PROJECT)
            dispatch('request', {
                id,
                mutationType: GET_PROJECT,
            })
                .then(({ data }) => {
                    commit(REQUEST_GET_PROJECT_SUCCESS)
                    commit(GET_PROJECT, {
                        data
                    })
                })
                .catch((error) => {
                    commit(REQUEST_GET_PROJECT_FAILURE, error)
                })
        } else {
            commit(GET_PROJECT, {
                data: null,
            })
        }

    },
    updateProject({ commit, dispatch }, payload={}) {
        const { id, data } = payload
        commit(REQUEST_UPDATE_PROJECT)
        dispatch('request', {
            id,
            data,
            mutationType: UPDATE_PROJECT,
        })
            .then(({ data }) => {
                commit(REQUEST_UPDATE_PROJECT_SUCCESS)
                commit(UPDATE_PROJECT, {
                    id: data.id,
                    data,
                })
            })
            .catch(() => {
                commit(REQUEST_UPDATE_PROJECT_FAILURE)
            })
    },
    deleteProject({ commit, dispatch }, payload={}) {
        const { id } = payload
        commit(REQUEST_DELETE_PROJECT)
        dispatch('request', {
            id,
            mutationType: DELETE_PROJECT,
        })
            .then(({ data }) => {
                commit(REQUEST_DELETE_PROJECT_SUCCESS)
                commit(DELETE_PROJECT, {
                    id: data.id
                })
            })
            .catch(() => {
                commit(REQUEST_DELETE_PROJECT_FAILURE)
            })
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
}