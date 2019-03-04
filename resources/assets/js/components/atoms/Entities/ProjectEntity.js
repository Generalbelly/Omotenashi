import Entity from "./Entity";

export default class ProjectEntity extends Entity {
    name = null
    protocol = null
    domain = null
    user_id = null
    oauth_entities = []
    tutorial_entities = []
    whitelisted_domain_entities = []
    google_analytics_property_entities = []

    googleAnalyticsAccounts = []

    constructor(data={}) {
        super()
        this.fill(data)
    }

}