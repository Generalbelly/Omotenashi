import Entity from "./Entity";

export default class ProjectEntity extends Entity {

    id = null
    name = null
    domain = null
    user_id = null
    user = null
    oauths = []
    tutorials = []
    whitelistedDomains = []

    constructor(data={}) {
        super()
        this.fill(data)
    }

}