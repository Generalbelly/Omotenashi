import Vue from 'vue'
import Buefy from 'buefy'
import VeeValidate from 'vee-validate'
import store from './store'
import App from './App.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
    faCode,
    faExternalLinkAlt,
    faPen,
    faQuestionCircle,
    faTrash,
    faSearch,
    faPlus,
    faArrowUp,
    faAngleLeft,
    faAngleRight
} from '@fortawesome/free-solid-svg-icons'

import {
    faFrown
} from '@fortawesome/free-regular-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(
    faCode,
    faExternalLinkAlt,
    faFrown,
    faPen,
    faQuestionCircle,
    faTrash,
    faSearch,
    faPlus,
    faArrowUp,
    faAngleLeft,
    faAngleRight
)

import "../sass/app.scss"

Vue.use(Buefy, {
    defaultIconPack: 'fas',
    defaultIconComponent: FontAwesomeIcon
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

const rootDiv = document.createElement('div')
rootDiv.id = "omotenashi"
document.body.appendChild(rootDiv)

new Vue({
    el: '#omotenashi',
    render: h => h(App),
    store,
})
