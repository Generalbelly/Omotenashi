import Entity from "./Entity";

export default class WhitelistedDomainEntity extends Entity {

    protocol = null
    domain = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}