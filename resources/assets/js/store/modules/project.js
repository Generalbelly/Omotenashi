import {
    makeRequest
} from '../../api/project'

import {
    LIST_PROJECTS,
    ADD_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,

    REQUEST_LIST_PROJECTS,
    REQUEST_LIST_PROJECTS_SUCCESS,
    REQUEST_LIST_PROJECTS_FAILURE,

    REQUEST_ADD_PROJECT,
    REQUEST_ADD_PROJECT_SUCCESS,
    REQUEST_ADD_PROJECT_FAILURE,

    REQUEST_UPDATE_PROJECT,
    REQUEST_UPDATE_PROJECT_SUCCESS,
    REQUEST_UPDATE_PROJECT_FAILURE,

    REQUEST_DELETE_PROJECT,
    REQUEST_DELETE_PROJECT_SUCCESS,
    REQUEST_DELETE_PROJECT_FAILURE,
} from '../mutation-types'

const state = {
    total: null,
    start: null,
    end: null,
    projects: [],
    isRequesting: false,
}

export const getters = {}

export const mutations = {
    [LIST_PROJECTS](state, { total, start, end, entities }) {
        state.total = total;
        state.start = start;
        state.end = end;
        state.projects = entities;
        console.log(state);
    },
    [ADD_PROJECT](state, { data }) {
        state.projects = [
            ...state.projects,
            data,
        ]
    },
    [UPDATE_PROJECT](state, { id, data }) {
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
    [DELETE_PROJECT](state, { id }) {
        const projectIndex = state.projects.findIndex(t => t.id === id)
        state.projects = [
            ...state.projects.slice(0, projectIndex),
            ...state.projects.slice(projectIndex+1),
        ]
    },
    [REQUEST_LIST_PROJECTS](state) {
        state.isRequesting = REQUEST_LIST_PROJECTS;
    },
    [REQUEST_LIST_PROJECTS_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_LIST_PROJECTS_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_ADD_PROJECT](state) {
        state.isRequesting = REQUEST_ADD_PROJECT
    },
    [REQUEST_ADD_PROJECT_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_ADD_PROJECT_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_UPDATE_PROJECT](state) {
        state.isRequesting = REQUEST_UPDATE_PROJECT
    },
    [REQUEST_UPDATE_PROJECT_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_UPDATE_PROJECT_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
    [REQUEST_DELETE_PROJECT](state) {
        state.isRequesting = REQUEST_DELETE_PROJECT
    },
    [REQUEST_DELETE_PROJECT_SUCCESS](state) {
        state.isRequesting = false
    },
    [REQUEST_DELETE_PROJECT_FAILURE](state, { errorCode, errorMsg }) {
        state.isRequesting = false
    },
}

export const actions = {
    listProjects({ commit }, { data }) {
        commit(REQUEST_LIST_PROJECTS)
        makeRequest({
            mutationType: REQUEST_LIST_PROJECTS,
            data,
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_PROJECTS_SUCCESS)
                const {
                    total,
                    start,
                    end,
                    entities,
                } = data
                commit(LIST_PROJECTS, {
                    total,
                    start,
                    end,
                    entities,
                })

            })
            .catch((error) => {
                commit(REQUEST_LIST_PROJECTS_FAILURE, error)
            });
    },
    addProject({ commit }, { data }) {
        commit(REQUEST_ADD_PROJECT)
        makeRequest({
            data,
            mutationType: ADD_PROJECT,
        })
            .then(({ data }) => {
                commit(REQUEST_ADD_PROJECT_SUCCESS)
                commit(ADD_PROJECT, { data })
            })
            .catch((error) => {
                commit(REQUEST_ADD_PROJECT_FAILURE, error)
            })
    },
    updateProject({ commit }, { id, data }) {
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
    deleteProject({ commit }, { id }) {
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
    getters,
    mutations,
    actions,
}