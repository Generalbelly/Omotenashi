import Project from "../../js/components/atoms/Entities/ProjectEntity";
import faker from 'faker';
import { formatDate } from "../utils";

class ProjectEntity {

    static generateDefaultData() {
        return {
            id: faker.random.uuid(),
            created_at: formatDate(faker.date.past()),
            updated_at: formatDate(faker.date.recent()),
        }
    }
    
    static create(count, dataset=[]) {
        let ProjectEntities = [];
        for (let i = 0; i < count; i++) {
            const defaultData = this.generateDefaultData();
            if (dataset[i]) {
                ProjectEntities.push(new Project({
                    ...defaultData,
                    ...dataset[i],
                }));
            } else {
                ProjectEntities.push(new Project(defaultData));
            }
        }
        return ProjectEntities;
    }

}