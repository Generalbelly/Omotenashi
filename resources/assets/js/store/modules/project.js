import {
    makeRequest
} from '../../api/project'

import {
    LIST_PROJECTS,
    ADD_PROJECT,
    GET_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,
    DELETE_OAUTH,
    LIST_GOOGLE_ANALYTICS,

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

    REQUEST_DELETE_OAUTH,
    REQUEST_DELETE_OAUTH_SUCCESS,
    REQUEST_DELETE_OAUTH_FAILURE,

    REQUEST_LIST_GOOGLE_ANALYTICS,
    REQUEST_LIST_GOOGLE_ANALYTICS_SUCCESS,
    REQUEST_LIST_GOOGLE_ANALYTICS_FAILURE,

    SET_ERROR_CODE,
} from '../mutation-types'

import ProjectEntity from "../../components/atoms/Entities/ProjectEntity";
import GoogleAnalyticsAccount from "../../components/atoms/Entities/GoogleAnalyticsAccount";

const state = {
    total: null,
    projectEntity: new ProjectEntity(),
    projectEntities: [],
    requestState: null,
}

const getters = {
    isRequesting(state) {
        return state.requestState != null && !/(FAILURE|SUCCESS)$/.exec(state.requestState);
    },
};

export const mutations = {
    [LIST_PROJECTS](state, payload) {
        const { total, entities } = payload
        state.total = total
        state.projectEntities = entities.map(entity => new ProjectEntity(entity));
        state.projectEntity = new ProjectEntity()
    },
    [ADD_PROJECT](state, payload) {
        const { data } = payload
        const projectEntity = new ProjectEntity(data)
        state.projectEntity = projectEntity
        state.projectEntities = [
            ...state.projectEntities,
            projectEntity,
        ]
    },
    [UPDATE_PROJECT](state, payload) {
        const { id, data } = payload
        const projectEntity = new ProjectEntity({
            id,
            ...data
        })
        state.projectEntity = projectEntity
        const projectIndex = state.projectEntities.findIndex(p => p.id === id)
        if (projectIndex !== -1) {
            state.projectEntities = [
                ...state.projectEntities.slice(0, projectIndex),
                projectEntity,
                ...state.projectEntities.slice(projectIndex+1),
            ]
        }
    },
    [DELETE_PROJECT](state, payload) {
        const { id } = payload
        const projectIndex = state.projectEntities.findIndex(p => p.id === id)
        if (projectIndex !== -1) {
            state.projectEntities = [
                ...state.projectEntities.slice(0, projectIndex),
                ...state.projectEntities.slice(projectIndex + 1),
            ]
        }
        this.projectEntity = null
    },
    [DELETE_OAUTH](state, payload) {
        const { id, project_id } = payload
        const projectEntity = new ProjectEntity({
            ...state.projectEntity,
            oauth_entities: state.projectEntity.oauth_entities.filter(o => o.id !== id),
        })
        state.projectEntity = projectEntity
        const projectIndex = state.projectEntities.findIndex(p => p.id === project_id)
        if (projectIndex !== -1) {
            state.projectEntities = [
                ...state.projectEntities.slice(0, projectIndex),
                projectEntity,
                ...state.projectEntities.slice(projectIndex+1),
            ]
        }
    },
    [LIST_GOOGLE_ANALYTICS](state, payload) {
        const { accounts, project_id } = payload
        const projectEntity = new ProjectEntity({
            ...state.projectEntity,
            googleAnalyticsAccounts: accounts.map(account => new GoogleAnalyticsAccount(account)),
        })
        state.projectEntity = projectEntity
        const projectIndex = state.projectEntities.findIndex(p => p.id === project_id)
        if (projectIndex !== -1) {
            state.projectEntities = [
                ...state.projectEntities.slice(0, projectIndex),
                projectEntity,
                ...state.projectEntities.slice(projectIndex+1),
            ]
        }
    },
    [REQUEST_LIST_PROJECTS](state) {
        state.requestState = REQUEST_LIST_PROJECTS
    },
    [REQUEST_LIST_PROJECTS_SUCCESS](state) {
        state.requestState = REQUEST_LIST_PROJECTS_SUCCESS
    },
    [REQUEST_LIST_PROJECTS_FAILURE](state, payload) {
        state.requestState = REQUEST_LIST_PROJECTS_FAILURE
    },
    [REQUEST_ADD_PROJECT](state) {
        state.requestState = REQUEST_ADD_PROJECT
    },
    [REQUEST_ADD_PROJECT_SUCCESS](state) {
        state.requestState = REQUEST_ADD_PROJECT_SUCCESS
    },
    [REQUEST_ADD_PROJECT_FAILURE](state, payload) {
        state.requestState = REQUEST_ADD_PROJECT_FAILURE
    },
    [GET_PROJECT](state, payload) {
        const { data } = payload
        state.projectEntity = new ProjectEntity(data)
    },
    [REQUEST_GET_PROJECT](state) {
        state.requestState = REQUEST_GET_PROJECT
    },
    [REQUEST_GET_PROJECT_SUCCESS](state) {
        state.requestState = REQUEST_GET_PROJECT_SUCCESS
    },
    [REQUEST_GET_PROJECT_FAILURE](state, payload) {
        state.requestState = REQUEST_GET_PROJECT_FAILURE
    },
    [REQUEST_UPDATE_PROJECT](state) {
        state.requestState = REQUEST_UPDATE_PROJECT
    },
    [REQUEST_UPDATE_PROJECT_SUCCESS](state) {
        state.requestState = REQUEST_UPDATE_PROJECT_SUCCESS
    },
    [REQUEST_UPDATE_PROJECT_FAILURE](state, payload) {
        state.requestState = REQUEST_UPDATE_PROJECT_FAILURE
    },
    [REQUEST_DELETE_PROJECT](state) {
        state.requestState = REQUEST_DELETE_PROJECT
    },
    [REQUEST_DELETE_PROJECT_SUCCESS](state) {
        state.requestState = REQUEST_DELETE_PROJECT_SUCCESS
    },
    [REQUEST_DELETE_PROJECT_FAILURE](state, payload) {
        state.requestState = REQUEST_DELETE_PROJECT_FAILURE
    },
    [REQUEST_DELETE_OAUTH](state) {
        state.requestState = REQUEST_DELETE_PROJECT
    },
    [REQUEST_DELETE_OAUTH_SUCCESS](state) {
        state.requestState = REQUEST_DELETE_OAUTH_SUCCESS
    },
    [REQUEST_DELETE_OAUTH_FAILURE](state, payload) {
        state.requestState = REQUEST_DELETE_OAUTH_FAILURE
    },
    [REQUEST_LIST_GOOGLE_ANALYTICS](state) {
        state.requestState = REQUEST_LIST_GOOGLE_ANALYTICS
    },
    [REQUEST_LIST_GOOGLE_ANALYTICS_SUCCESS](state) {
        state.requestState = REQUEST_LIST_GOOGLE_ANALYTICS_SUCCESS
    },
    [REQUEST_LIST_GOOGLE_ANALYTICS_FAILURE](state, payload) {
        state.requestState = REQUEST_LIST_GOOGLE_ANALYTICS_FAILURE
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
        return new Promise(resolve => {
            dispatch('request', {
                data,
                mutationType: ADD_PROJECT,
            })
                .then((response) => {
                    const { data } = response
                    commit(REQUEST_ADD_PROJECT_SUCCESS)
                    commit(ADD_PROJECT, {
                        data
                    })
                    resolve(response)
                })
                .catch((error) => {
                    commit(REQUEST_ADD_PROJECT_FAILURE, error)
                })
        })
    },
    getProject({ commit, dispatch }, payload={}) {
        const { id } = payload
        if (id) {
            commit(REQUEST_GET_PROJECT)
            return new Promise(resolve => {
                dispatch('request', {
                    id,
                    mutationType: GET_PROJECT,
                })
                    .then((response) => {
                        const { data } = response
                        commit(REQUEST_GET_PROJECT_SUCCESS)
                        commit(GET_PROJECT, {
                            data
                        })
                        resolve(data);
                    })
                    .catch((error) => {
                        commit(REQUEST_GET_PROJECT_FAILURE, error)
                    })
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
        return new Promise(resolve => {
            dispatch('request', {
                id,
                mutationType: DELETE_PROJECT,
            })
                .then((response) => {
                    const { data } = response
                    commit(REQUEST_DELETE_PROJECT_SUCCESS)
                    commit(DELETE_PROJECT, {
                        id: data.id
                    })
                    resolve(response);
                })
                .catch(() => {
                    commit(REQUEST_DELETE_PROJECT_FAILURE)
                })
        });
    },
    deleteOAuth({ commit, dispatch }, payload={}) {
        const { id } = payload
        commit(REQUEST_DELETE_OAUTH)
        dispatch('request', {
            id,
            mutationType: DELETE_OAUTH,
        })
            .then(({ data }) => {
                commit(REQUEST_DELETE_OAUTH_SUCCESS)
                commit(DELETE_OAUTH, {
                    id: data.id,
                    project_id: data.project_id,
                })
            })
            .catch(() => {
                commit(REQUEST_DELETE_OAUTH_FAILURE)
            })
    },
    listGoogleAnalyticsAccounts({ commit, dispatch }, payload={}) {
        const { id } = payload
        commit(REQUEST_LIST_GOOGLE_ANALYTICS)
        dispatch('request', {
            id,
            mutationType: LIST_GOOGLE_ANALYTICS,
        })
            .then(({ data }) => {
                commit(REQUEST_LIST_GOOGLE_ANALYTICS_SUCCESS)
                commit(LIST_GOOGLE_ANALYTICS, {
                    accounts: data.accounts,
                    project_id: data.project_id,
                })
            })
            .catch(() => {
                commit(REQUEST_LIST_GOOGLE_ANALYTICS_FAILURE)
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