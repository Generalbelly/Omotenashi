import {
    LIST_PROJECTS,
    ADD_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,
    GET_PROJECT,
} from '../store/mutation-types'

import {
    APIController
} from "./common"

const projectApi = new APIController('projects')

export const makeRequest = ({ id, data, mutationType, params }) => {
    switch (mutationType) {
        case LIST_PROJECTS:
            return projectApi.list(params)
        case GET_PROJECT:
            return projectApi.show(id)
        case ADD_PROJECT:
            return projectApi.add(data)
        case UPDATE_PROJECT:
            return projectApi.updateEntity(data, id)
        case DELETE_PROJECT:
            projectApi.delete(id)
        default:
            break
    }
}

