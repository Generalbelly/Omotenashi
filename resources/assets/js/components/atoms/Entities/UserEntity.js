import Entity from "./Entity";

export default class UserEntity extends Entity {

    key = null
    email = null

    constructor(data={}) {
        super()
        this.fill(data)
    }

}