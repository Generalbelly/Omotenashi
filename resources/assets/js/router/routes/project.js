import ProjectsPage from '../../components/pages/ProjectsPage'
import ProjectPage from '../../components/pages/ProjectPage'

export default [
    {
        path: '/projects',
        name: 'projects.index',
        component: ProjectsPage,
    },
    {
        path: '/projects/create',
        name: 'projects.create',
        component: ProjectPage,
    },
    {
        path: '/projects/:id',
        name: 'projects.show',
        component: ProjectPage,
        props: true,
    },
];