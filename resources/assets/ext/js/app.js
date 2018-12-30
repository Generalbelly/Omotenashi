import Vue from 'vue'
import VeeValidate from 'vee-validate';

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faHome,
    faPlay,
    faCircle,
    faPlus,
    faPlusCircle,
    faTrash,
    faPen,
    faEdit,
    faExchangeAlt,
    faTimes,
    faExclamationCircle,
    faCheck,
} from '@fortawesome'

import store from './store'
import App from './App.vue'

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

library.add(
    faHome,
    faPlay,
    faCircle,
    faPlus,
    faPlusCircle,
    faTrash,
    faPen,
    faEdit,
    faExchangeAlt,
    faTimes,
    faExclamationCircle,
    faCheck,
)

Vue.component('font-awesome-icon', FontAwesomeIcon)

// import LogRocket from 'logrocket';
// LogRocket.init('agnj7d/omotenashi');


import "../sass/app.scss"

const rootDiv = document.createElement('div')
rootDiv.id = "omotenashi"
document.body.appendChild(rootDiv)

new Vue({
    el: '#omotenashi',
    render: h => h(App),
    store,
})
