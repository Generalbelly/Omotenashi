import Entity from "./Entity";

export default class OAuthEntity extends Entity {

    id = null
    service = null
    email = null
    refresh_token = null
    access_token = null
    expired_at = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}