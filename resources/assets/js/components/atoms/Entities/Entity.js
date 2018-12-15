export default class Entity {
    fill(data={}) {
        Object.keys(data).forEach(field => {
            if (this.hasOwnProperty(field)) {
                this[field] = data[field];
            }
        });
    }
}