import Vue from 'vue'
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
} from '@fortawesome'
// import store from './store'
import mixins from '../../ext/js/mixins'

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

Vue.mixin(mixins)

export default Vue;
