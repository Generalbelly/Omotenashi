import Vue from 'vue'
import Vuex from 'vuex'
import modules from './modules'
import {SET_ERROR_CODE, SET_USER} from "./mutation-types";
import UserEntity from "../components/atoms/Entities/UserEntity";

Vue.use(Vuex)

const state = {
    iam: null,
    errorCode: null,
}

const getters = {
    userKey(state) {
        return state.iam ? state.iam.key : null
    }
}

const mutations = {
    [SET_ERROR_CODE](state, code) {
        state.errorCode = code
    },
    [SET_USER](state, iam) {
        state.iam = new UserEntity(iam)
    }
}

const actions = {
    setUser({ commit }, iam) {
        commit(SET_USER, iam);
    },
}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules,
    strict: process.env.NODE_ENV !== 'production',
})
