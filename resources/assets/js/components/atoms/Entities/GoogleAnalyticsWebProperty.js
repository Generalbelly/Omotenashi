import Entity from "./Entity";

export default class GoogleAnalyticsWebProperty extends Entity {

    id = null
    name = null
    websiteUrl = null

    constructor(data={}) {
        super()
        const { profiles, ...otherProps } = data;
        this.fill(otherProps)
    }

}