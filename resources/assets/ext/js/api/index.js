import uuidv4 from 'uuid'
import axios from 'axios'
import {
    REQUEST_GET_TUTORIALS,
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

    switch (mutationType) {
        case REQUEST_GET_TUTORIALS:
            return new Promise((resolve, reject) => {
                axios.get('/', {
                    params: data,
                })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
            });
        case ADD_TUTORIAL:
            return new Promise((resolve, reject) => {
                axios.post('/store', data)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
            });
        case UPDATE_TUTORIAL:
            return new Promise((resolve, reject) => {
                axios.put(`/${id}`, data)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
            })
        case DELETE_TUTORIAL:
            return new Promise((resolve, reject) => {
                axios.delete(`/${id}`, data)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
            })
        default:
            break
    }
}