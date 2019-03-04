import {
    LIST_PROJECTS,
    ADD_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,
    GET_PROJECT,
    DELETE_OAUTH,
    UPDATE_GOOGLE_ANALYTICS,
    LIST_GOOGLE_ANALYTICS,
} from '../store/mutation-types'

import {
    BaseAPI
} from "./common"

const projectApi = new BaseAPI('projects')
const oauthApi = new BaseAPI('oauths')
const googleAnalyticsApi = new BaseAPI('google-analytics')

export const makeRequest = ({ id, data, mutationType, params }) => {
    switch (mutationType) {
        case LIST_PROJECTS:
            return projectApi.list(params)
        case GET_PROJECT:
            return projectApi.get(id)
        case ADD_PROJECT:
            return projectApi.add(data)
        case UPDATE_PROJECT:
            return projectApi.update(id, data)
        case DELETE_PROJECT:
            return projectApi.delete(id)
        case DELETE_OAUTH:
            return oauthApi.delete(id)
        case UPDATE_GOOGLE_ANALYTICS:
            return googleAnalyticsApi.list(params)
        case LIST_GOOGLE_ANALYTICS:
            return googleAnalyticsApi.get(id)
        default:
            break
    }
}

