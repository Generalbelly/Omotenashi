import Vue from 'vue'
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'
import '../sass/app.scss'
import VeeValidate from 'vee-validate'
import store from './store'
import './bootstrap'
import App from './App.vue'

Vue.use(Buefy, {
    defaultIconPack: "fa",
})
Vue.use(VeeValidate)

// import LogRocket from 'logrocket';
// LogRocket.init('agnj7d/omotenashi');

new Vue({
    el: '#app',
    render: h => h(App),
    store,
})
