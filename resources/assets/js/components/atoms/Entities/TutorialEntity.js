import Entity from "./Entity";

export default class TutorialEntity extends Entity {

    name = null
    description = null
    steps = []
    path = {
        deepness: 0,
        value: null,
        regex: false,
    }
    parameters = []
    project_id = null

    constructor(data={}) {
        super()
        this.fill(data)
        if (!data.path) {
            const pathname = window.location.pathname;
            this.path.value = pathname;
            this.path.deepness = pathname === '/' ? 0 : pathname.split('/').length - 1;
        }
    }

}