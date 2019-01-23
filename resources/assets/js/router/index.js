import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes';

Vue.use(VueRouter);
console.log(routes);
export default new VueRouter({
    mode: 'history',
    routes,
});