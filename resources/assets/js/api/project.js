import {
    REQUEST_LIST_PROJECTS,
    ADD_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,
} from '../store/mutation-types'

import {
    APIController
} from "./common"

const projectApi = new APIController('projects')

export const makeRequest = ({ id, data, mutationType, params }) => {
    switch (mutationType) {
        case REQUEST_LIST_PROJECTS:
            console.log(params);
            return projectApi.listEntities(params)
        case ADD_PROJECT:
            return projectApi.addEntity(data)
        case UPDATE_PROJECT:
            return projectApi.updateEntity(data, id)
        case DELETE_PROJECT:
            projectApi.deleteEntity(id)
        default:
            break
    }
}

