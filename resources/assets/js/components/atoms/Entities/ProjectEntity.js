import Entity from "./Entity";
import GoogleAnalyticsPropertyEntity from "./GoogleAnalyticsPropertyEntity";
import TutorialEntity from "./TutorialEntity";
import OAuthEntity from "./OAuthEntity";

export default class ProjectEntity extends Entity {

    name = null
    protocol = null
    domain = null
    user_id = null
    tutorial_settings = {
        distribution_ratio: 'random',
        only_once: true,
        only_once_duration: 'forever',
    };
    oauth_entities = []
    tutorial_entities = []
    google_analytics_property_entities = []

    googleAnalyticsAccounts = []

    constructor(data={}) {
        super()
        const {
            google_analytics_property_entities = [],
            tutorial_entities = [],
            oauth_entities = [],
            ...props
        } = data
        this.fill({
            ...props,
            google_analytics_property_entities: google_analytics_property_entities.map(e => new GoogleAnalyticsPropertyEntity(e)),
            tutorial_entities: tutorial_entities.map(e => new TutorialEntity(e)),
            oauth_entities: oauth_entities.map(e => new OAuthEntity(e)),
        })
    }

}