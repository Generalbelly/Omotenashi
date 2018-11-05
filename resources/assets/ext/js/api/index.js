import uuidv4 from 'uuid'
import axios from 'axios'
import {
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL, REQUEST_GET_TUTORIALS,
} from '../store/mutation-types'

axios.defaults.baseURL = 'http://docker.omotenashi.today/api/tutorials';
axios.defaults.headers.common['Authorization'] = `Bearer ${_ot_ext_token}`;

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case REQUEST_GET_TUTORIALS:
            return new Promise((resolve, reject) => {
                axios.get('/')
                    .then((response) => {
                        console.log(response);
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log(error);
                        reject(error);
                    });
            });
        case ADD_TUTORIAL:
            return new Promise((resolve, reject) => {
                axios.post('/store', data)
                    .then((response) => {
                        console.log(response);
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log(error);
                        reject(error);
                    });
            });
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