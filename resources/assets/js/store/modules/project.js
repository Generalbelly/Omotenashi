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
} from '../mutation-types'

import ProjectEntity from "../../components/atoms/Entities/ProjectEntity";

const state = {
    total: null,
    project: new ProjectEntity(),
    projects: [],
    isRequesting: false,
    requestState: null,
}

export const mutations = {
    [LIST_PROJECTS](state, payload) {
        const { total, entities } = payload
        state.total = total
        state.projects = entities
    },
    [ADD_PROJECT](state, payload) {
        const { data } = payload
        state.projects = [
            ...state.projects,
            data,
        ]
    },
    [UPDATE_PROJECT](state, payload) {
        const { id, data } = payload
        const projectIndex = state.projects.findIndex(t => t.id === id)
        state.projects = [
            ...state.projects.slice(0, projectIndex),
            {
                id,
                ...data
            },
            ...state.projects.slice(projectIndex+1),
        ]
    },
    [DELETE_PROJECT](state, payload) {
        const { id } = payload
        const projectIndex = state.projects.findIndex(t => t.id === id)
        state.projects = [
            ...state.projects.slice(0, projectIndex),
            ...state.projects.slice(projectIndex+1),
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
        const { errorCode, errorMsg } = payload
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
        const { errorCode, errorMsg } = payload
        state.isRequesting = false
        state.requestState = REQUEST_ADD_PROJECT_FAILURE
    },
    [GET_PROJECT](state, payload) {
        const { data } = payload;
        state.project = data
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
        const { errorCode, errorMsg } = payload
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
        const { errorCode, errorMsg } = payload
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
        const { errorCode, errorMsg } = payload
        state.isRequesting = false
        state.requestState = REQUEST_DELETE_PROJECT_FAILURE
    },
}

export const actions = {
    listProjects({ commit, state }, payload={}) {
        commit(REQUEST_LIST_PROJECTS)
        const { pagination={}, q=null, } = payload;
        makeRequest({
            mutationType: LIST_PROJECTS,
            params: {
                orderBy: pagination.orderBy,
                q,
            }
        })
            .then(({ data }) => {
                console.log(data);
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
    addProject({ commit }, payload={}) {
        const { data } = payload
        commit(REQUEST_ADD_PROJECT)
        makeRequest({
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
    getProject({ commit }, payload={}) {
        const { id } = payload
        if (id) {
            commit(REQUEST_GET_PROJECT)
            makeRequest({
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
    updateProject({ commit }, payload={}) {
        const { id, data } = payload
        commit(REQUEST_UPDATE_PROJECT)
        makeRequest({
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
    deleteProject({ commit }, payload={}) {
        const { id } = payload
        commit(REQUEST_DELETE_PROJECT)
        makeRequest({
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