import Vue from 'vue'
import App from './App.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
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
} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import store from './store'

// import LogRocket from 'logrocket';
// LogRocket.init('agnj7d/omotenashi');

library.add(
    faHome,
    faPlay,
    faCircle,
    faPlus,
    faPlusCircle,
    faTrash,
    faPen,
    faEdit,
    faExchangeAlt
)
Vue.component('font-awesome-icon', FontAwesomeIcon)

import "../sass/app.scss"

const rootDiv = document.createElement('div')
rootDiv.id = "omotenashi"
document.body.appendChild(rootDiv)

new Vue({
    el: '#omotenashi',
    render: h => h(App),
    store,
})
