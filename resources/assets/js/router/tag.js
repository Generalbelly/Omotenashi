import TagPage from '../components/pages/TagPage'

const tagRoutes = [
    {
        path: '/tags/:id',
        name: 'tags.show',
        component: TagPage,
    },
];

export default tagRoutes;