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
    _parameters = []

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

        this.url =  data.url ?  data.url : window.location.href;

        const url = new URL(this.url);
        this.urlPath = url.origin + url.pathname
    }

    get parameters() {
        return this._parameters;
    }

    set parameters(value) {
        this._parameters = value
        this.url = this.urlPath + this.formatParameters(value)
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