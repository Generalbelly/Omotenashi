import uuidv4 from 'uuid'
import axios from 'axios'
import {
    REQUEST_GET_TUTORIALS,
    ADD_TUTORIAL,
    UPDATE_TUTORIAL,
    DELETE_TUTORIAL,
} from '../store/mutation-types'

const GET_METHOD = 'GET';
const POST_METHOD = 'POST';
const PUT_METHOD = 'PUT';
const DELETE_METHOD = 'DELETE';

const request = ({ url, method, data }) => {
    return new Promise((resolve, reject) => {
        console.log('new');
        axios({
            url,
            method,
            data,
        })
            .then((response) => {
                resolve(response);
            })
            .catch((error) => {
                reject(error);
            })
    })
}

export const makeRequest = (params) => {
    const {
        id,
        data,
        mutationType,
    } = params

    switch (mutationType) {
        case REQUEST_GET_TUTORIALS:
            return request({
                url: '/',
                method: GET_METHOD,
                data,
            })
        case ADD_TUTORIAL:
            return request({
                url: '/',
                method: POST_METHOD,
                data,
            })
        case UPDATE_TUTORIAL:
            return request({
                url: `/${id}`,
                method: PUT_METHOD,
                data,
            })
        case DELETE_TUTORIAL:
            return request({
                url: `/${id}`,
                method: DELETE_METHOD,
                data,
            })
        default:
            break
    }
}