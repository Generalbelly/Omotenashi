import Vue from 'vue'
import VueRouter from 'vue-router'
import projectRoutes from './project';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            redirect: '/projects',
        },
        ...projectRoutes,
    ],
});