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
} from '@fortawesome'

import store from './store'
import mixins from '../../js/components/mixins'
import App from './App.vue'

Vue.use(VeeValidate);

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
)

Vue.component('font-awesome-icon', FontAwesomeIcon)


// Vue.mixin(mixins)

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
