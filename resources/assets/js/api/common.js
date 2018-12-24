import axios from 'axios'

export const GET_METHOD = 'GET';
export const POST_METHOD = 'POST';
export const PUT_METHOD = 'PUT';
export const DELETE_METHOD = 'DELETE';

const request = ({ url, method, data, params }) => {
    return new Promise((resolve, reject) => {
        axios({
            url,
            method,
            data,
            params,
        })
            .then((response) => {
                resolve(response);
            })
            .catch((error) => {
                reject(error);
            })
    })
}

export class APIController {

    constructor(basePath) {
        this.basePath = basePath
    }

    list(params) {
        console.log(params);
        return request({
            url: `/${this.basePath}/`,
            method: GET_METHOD,
            params,
        })
    }

    add(data) {
        return request({
            url: `/${this.basePath}/`,
            method: POST_METHOD,
            data,
        })
    }

    show(id) {
        return request({
            url:`/${this.basePath}/${id}`,
            method: GET_METHOD,
        })
    }

    updateEntity(data, id) {
        return request({
            url:`/${this.basePath}/${id}`,
            method: PUT_METHOD,
            data,
        })
    }

    delete(id) {
        return request({
            url: `/${this.basePath}/${id}`,
            method: DELETE_METHOD,
        })
    }
}