
import Vue from 'vue'
import Vuex from 'vuex'

import modules from './modules'

Vue.use(Vuex)

export const state = {
}

export const mutations = {
}

export const actions = {
}

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules,
    strict: process.env.NODE_ENV !== 'production',
})
