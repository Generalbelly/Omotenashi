import {
    REQUEST_LIST_PROJECTS,
    ADD_PROJECT,
    UPDATE_PROJECT,
    DELETE_PROJECT,
} from '../store/mutation-types'

import {
    api
} from "./common"

const projectApi = api('projects')

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case REQUEST_LIST_PROJECTS:
            return projectApi.listEntities({
                data,
            })
        case ADD_PROJECT:
            return projectApi.addEntity({
                data,
            })
        case UPDATE_PROJECT:
            return projectApi.updateEntity({
                data
            })
        case DELETE_PROJECT:
            projectApi.deleteEntity({
                id,
                data,
            })
        default:
            break
    }
}

