import Entity from "./Entity";

export default class GoogleAnalyticsPropertyEntity extends Entity {

    id = null
    account_id = null
    account_name = null
    property_id = null
    property_name = null
    website_url = null
    project_id = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}