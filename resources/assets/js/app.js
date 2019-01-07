import Vue from 'vue'
import Buefy from 'buefy'
import VeeValidate from 'vee-validate'
import store from './store'
import '../sass/app.scss'
// import 'buefy/dist/buefy.css'
import './bootstrap'
import router from './router'
import App from './App.vue'

Vue.use(Buefy, {
    defaultIconPack: "fas",
})
Vue.use(VeeValidate, {
    aria: true,
    classNames: {},
    classes: false,
    delay: 1,
    dictionary: null,
    errorBagName: 'errors', // change if property conflicts
    events: 'input|blur',
    fieldsBagName: 'fields',
    i18n: null, // the vue-i18n plugin instance
    i18nRootKey: 'validations', // the nested key under which the validation messages will be located
    inject: true,
    locale: 'en',
    validity: false
})

// import LogRocket from 'logrocket';
// LogRocket.init('agnj7d/omotenashi');

new Vue({
    el: '#app',
    render: h => h(App),
    store,
    router,
})
