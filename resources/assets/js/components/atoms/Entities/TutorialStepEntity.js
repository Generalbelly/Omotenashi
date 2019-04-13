import Entity from "./Entity";

export default class TutorialStepEntity extends Entity {

    type = null
    target = null
    value = null
    config = null
    tutorial_id = null

    tutorialEntity = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}