import TutorialsPage from "../../components/pages/TutorialsPage";
import TutorialPage from "../../components/pages/TutorialPage";

export default [
    {
        path: '/projects/:projectId/tutorials',
        name: 'tutorials.index',
        component: TutorialsPage,
        props: true,
    },
    {
        path: '/projects/:projectId/tutorials/create',
        name: 'tutorials.create',
        component: TutorialPage,
        props: true,
    },
    {
        path: '/projects/:projectId/tutorials/:id',
        name: 'tutorials.show',
        component: TutorialPage,
        props: true,
    },
];