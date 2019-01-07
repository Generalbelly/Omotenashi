import Entity from "./Entity";

export default class ProjectEntity extends Entity {

    id = null
    name = null
    protocol = null
    domain = null
    user_id = null
    user = null
    oauths = []
    tutorials = []
    whitelisted_domain_entities = []
    created_at = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}