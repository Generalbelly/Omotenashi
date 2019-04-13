import Entity from "./Entity";
import TutorialStepEntity from "./TutorialStepEntity";
import ProjectEntity from "./ProjectEntity";

export default class TutorialEntity extends Entity {

    name = null
    description = null
    operator = null
    depth = 0
    path = null
    query = null
    parameters = []
    last_time_used_at = null

    settings = {}

    project_id = null

    projectEntity = null
    tutorialStepEntities = []

    constructor(data={}) {
        super()
        const {
            tutorialStepEntities = [],
            path = null,
            projectEntity = null,
            ...props
        } = data

        this.fill(props)

        if (!path) {
            const pathname = window.location.pathname;
            this.path = pathname;
            this.depth = pathname === '/' ? 0 : pathname.split('/').length - 1;
        }
        if (tutorialStepEntities) {
            this.tutorialStepEntities = tutorialStepEntities.map(e => new TutorialStepEntity(e))
        }
        if (projectEntity) {
            this.projectEntity = new ProjectEntity(projectEntity);
        }
    }

}