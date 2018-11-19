import {
    REQUEST_LIST_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

import {
    api
} from "./common"

const tutorialApi = api('tutorials')

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case REQUEST_LIST_TUTORIALS:
            return tutorialApi.listEntities({
                data,
            })
        case ADD_TUTORIAL:
            return tutorialApi.addEntity({
                data,
            })
        case UPDATE_TUTORIAL:
            return tutorialApi.updateEntity({
                data
            })
        case DELETE_TUTORIAL:
            return tutorialApi.deleteEntity({
                id,
                data,
            })
        default:
            break
    }
}
