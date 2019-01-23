import Entity from "./Entity";

export default class ProjectEntity extends Entity {
    name = null
    protocol = null
    domain = null
    user_id = null
    user = null
    oauth_entities = []
    tutorial_entities = []
    whitelisted_domain_entities = []

    constructor(data={}) {
        super()
        this.fill(data)
    }

}