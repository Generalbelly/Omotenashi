import Entity from "./Entity";

export default class ProjectEntity extends Entity {

    name = null;
    domain = null;
    user_id = null;
    user = null;
    oauths = [];
    tutorials = [];

    constructor(data={}) {
        super();
        super.fill(data)
    }

}