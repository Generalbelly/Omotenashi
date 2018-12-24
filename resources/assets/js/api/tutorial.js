import {
    REQUEST_LIST_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

import {
    APIController
} from "./common"

const tutorialApi = new APIController('tutorials')

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case REQUEST_LIST_TUTORIALS:
            return tutorialApi.list({
                data,
            })
        case ADD_TUTORIAL:
            return tutorialApi.add({
                data,
            })
        case UPDATE_TUTORIAL:
            return tutorialApi.updateEntity({
                data
            })
        case DELETE_TUTORIAL:
            return tutorialApi.delete({
                id,
                data,
            })
        default:
            break
    }
}
