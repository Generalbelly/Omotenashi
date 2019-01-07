import Entity from "./Entity";

export default class WhitelistedDomainEntity extends Entity {

    id = null
    protocol = null
    domain = null
    created_at = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}