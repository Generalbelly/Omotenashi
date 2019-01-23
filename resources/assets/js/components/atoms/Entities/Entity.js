export default class Entity {
    id = null
    created_at = null
    updated_at = null

    fill(data={}) {
        Object.keys(data).forEach(field => {
            if (this.hasOwnProperty(field)) {
                this[field] = data[field];
            }
        });
    }
}