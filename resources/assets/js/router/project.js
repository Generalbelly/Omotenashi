import ProjectsPage from '../components/pages/ProjectsPage'
import ProjectPage from '../components/pages/ProjectPage'

const projectRoutes = [
    {
        path: '/projects',
        name: 'projects.index',
        component: ProjectsPage,
        children: [
            {
                path: 'create',
                name: 'projects.create',
                component: ProjectPage,
            },
            {
                path: '/projects/:id',
                name: 'projects.show',
                component: ProjectPage,
            },
        ],
    },
];

export default projectRoutes;