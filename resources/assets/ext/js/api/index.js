import uuidv4 from 'uuid'
import {
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case ADD_TUTORIAL:
            return new Promise((resolve, reject) => {
                window.setTimeout(() => {
                    resolve({
                        id: uuidv4(),
                        ...data
                    })
                }, 3000)
            })
        case UPDATE_TUTORIAL:
            return new Promise((resolve, reject) => {
                window.setTimeout(() => {
                    resolve({
                        id,
                        ...data,
                    })
                }, 3000)
            })
        case DELETE_TUTORIAL:
            return new Promise((resolve, reject) => {
                window.setTimeout(() => {
                    resolve({
                        id,
                        ...data,
                    })
                }, 3000)
            })
        default:
            break
    }
}