import axios from 'axios'
import {
    GET_METHOD,
    POST_METHOD,
    PUT_METHOD,
    DELETE_METHOD,
} from "../utils/constants";

export class BaseAPI {

    constructor(basePath) {
        this.basePath = basePath
    }

    request(params) {
        return axios(params)
    }

    list(params) {
        return this.request({
            url: `/${this.basePath}/`,
            method: GET_METHOD,
            params,
        })
    }

    add(data) {
        return this.request({
            url: `/${this.basePath}/`,
            method: POST_METHOD,
            data,
        })
    }

    get(id) {
        return this.request({
            url:`/${this.basePath}/${id}`,
            method: GET_METHOD,
        })
    }

    update(id, data) {
        return this.request({
            url:`/${this.basePath}/${id}`,
            method: PUT_METHOD,
            data,
        })
    }

    delete(id) {
        return this.request({
            url: `/${this.basePath}/${id}`,
            method: DELETE_METHOD,
        })
    }
}