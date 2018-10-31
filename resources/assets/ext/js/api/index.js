import uuidv4 from 'uuid'
import axios from 'axios'
import {
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

axios.defaults.baseURL = 'http://docker.omotenashi.today/api/tutorials';
axios.defaults.headers.common['Authorization'] = `Bearer ${_ot_ext_token}`;

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    console.log(_ot_ext_token);

    switch (mutationType) {
        case ADD_TUTORIAL:
            return axios.post('/store', {
                data,
            })
        case UPDATE_TUTORIAL:
            return new Promise((resolve, reject) => {
                window.setTimeout(() => {
                    resolve({
                        id,
                        ...data,
                        steps: data.steps.map(s => {
                            if(!s.id) {
                                s.id = uuidv4()
                            }
                            return s
                        }),
                    })
                }, 1500)
            })
        case DELETE_TUTORIAL:
            return new Promise((resolve, reject) => {
                window.setTimeout(() => {
                    resolve({
                        id,
                        ...data,
                    })
                }, 1500)
            })
        default:
            break
    }
}