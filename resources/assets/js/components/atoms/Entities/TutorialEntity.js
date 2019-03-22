import Entity from "./Entity";

export default class TutorialEntity extends Entity {

    name = null
    description = null
    steps = []
    path = null
    query = null
    url = null
    project_id = null

    urlPath = null
    parameters = []

    constructor(data={}) {
        super()
        this.fill(data)
        if (data.query) {
            this.parameters = data.query.split('&').map(param => {
                const pair = param.split('=')
                return {
                    key: pair[0],
                    value: pair[1],
                }
            });
        }

        this.url =  data.url ? data.url : this.getCurrentUrl();

        const url = new URL(this.url);
        this.urlPath = url.origin + url.pathname
    }

    getCurrentUrl() {
        return window.location.href;
    }

    getUrlCurrentUrlPath() {
        return this.urlPath + this.formatParameters(this.parameters)
    }

    formatParameters(params) {
        return params.reduce((total, current, index) => {
            if (current.key && current.value) {
                if (index === 0) {
                    return `?${total}${current.key}=${current.value}`
                } else {
                    return `${total}&${current.key}=${current.value}`
                }
            } else {
                return total;
            }
        }, '');
    }
}