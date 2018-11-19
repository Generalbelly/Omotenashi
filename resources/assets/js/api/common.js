import axios from 'axios'

export const GET_METHOD = 'GET';
export const POST_METHOD = 'POST';
export const PUT_METHOD = 'PUT';
export const DELETE_METHOD = 'DELETE';

const request = ({ url, method, data }) => {
    return new Promise((resolve, reject) => {
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

export const api = (basePath) => {
    const listEntities = ({ data }) => {
        return request({
            url: `${basePath}/`,
            method: GET_METHOD,
            data,
        })
    }
    const addEntity = ({ data }) => {
        return request({
            url: `${basePath}/`,
            method: POST_METHOD,
            data,
        })
    }
    const updateEntity = ({ data, id }) => {
        return request({
            url:`${basePath}/${id}`,
            method: PUT_METHOD,
            data,
        })
    }
    const deleteEntity = ({ data, id }) => {
        return request({
            url: `${basePath}/${id}`,
            method: DELETE_METHOD,
            data,
        })
    }
    return {
        listEntities,
        addEntity,
        updateEntity,
        deleteEntity
    }
}