import Vue from 'vue'
import VueRouter from 'vue-router'
import projectRoutes from './project';
import tagRoutes from './tag';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            redirect: '/projects',
        },
        ...projectRoutes,
        ...tagRoutes,
    ],
});