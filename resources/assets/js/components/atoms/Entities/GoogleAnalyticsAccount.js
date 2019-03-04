import Entity from "./Entity";
import GoogleAnalyticsWebProperty from "./GoogleAnalyticsWebProperty";

export default class GoogleAnalyticsAccount extends Entity {

    id = null
    name = null
    webProperties = []

    constructor(data={}) {
        super()
        const { webProperties, ...otherProps } = data;
        this.fill(otherProps)
        this.webProperties = webProperties.map(webProperty => new GoogleAnalyticsWebProperty(webProperty))
    }

}