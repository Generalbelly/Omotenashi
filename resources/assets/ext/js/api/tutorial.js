import {
    LIST_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

import APIController from "./common"

const tutorialApi = new APIController('tutorials')

export const makeRequest = ({ id, data, mutationType, params }) => {
    switch (mutationType) {
        case LIST_TUTORIALS:
            return tutorialApi.list(params)
        case ADD_TUTORIAL:
            return tutorialApi.add(data)
        case UPDATE_TUTORIAL:
            return tutorialApi.update(id, data)
        case DELETE_TUTORIAL:
            return tutorialApi.delete(id)
        default:
            break
    }
}

