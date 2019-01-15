import Vue from 'vue'
import Vuex from 'vuex'

import modules from './modules'

import { SET_USER } from './mutation-types'

Vue.use(Vuex)

export const state = {
    userEntity: null,
}

export const mutations = {
    [SET_USER](state, payload) {
        state.userEntity = payload
    }
}

export const actions = {
    setUser({commit}, userEntity) {
        commit(SET_USER, userEntity)
    }
}

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules,
    strict: process.env.NODE_ENV !== 'production',
})
