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
                switch(error.response.status) {
                    case 401:
                    case 419:
                        //TODO: 再度ログインしてください的なDialog入れて、再ログインしたら元のページに戻りたい
                        // TODO: リリース前に消す
                        if (window.location.hostname === 'docker.omotenashi.today' || 'localhost') {
                            document.location.href = '/login'
                        }
                        break
                    default:
                        reject(error.response)
                        break
                }
            })
    })
}

export class APIController {

    constructor(basePath) {
        this.basePath = basePath
    }

    list(params) {
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

    get(id) {
        return request({
            url:`/${this.basePath}/${id}`,
            method: GET_METHOD,
        })
    }

    update(id, data) {
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