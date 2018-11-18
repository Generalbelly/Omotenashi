
import Vue from 'vue'
import Vuex from 'vuex'

import modules from './modules'
import {
    RETRIEVE_LOG,
    SAVE_LOG,
    EXT_LOG_KEY,
} from "./mutation-types";

Vue.use(Vuex)

export const state = {
    extLog: {
        userIsFirstTime: true,
        checkedMessages: [],
    },
}

export const mutations = {
    [RETRIEVE_LOG] (state) {
        try {
            const savedLog = JSON.parse(localStorage.getItem(EXT_LOG_KEY))
            if (savedLog) {
                state.extLog = savedLog
            }
        } catch(e) {
        }
    },
    [SAVE_LOG](state, data) {
        try {
            state.extLog = {
                ...state.extLog,
                ...data,
            }
            localStorage.setItem(EXT_LOG_KEY, JSON.stringify(state.extLog))
        } catch (e) {
        }
    },
}

export const actions = {
    retrieveLog({ commit }, tutorial) {
        commit(RETRIEVE_LOG, tutorial)
    },
    saveLog({ commit }, data) {
        commit(SAVE_LOG, data)
    },
}

export default new Vuex.Store({
    state,
    mutations,
    actions,
    modules,
    strict: process.env.NODE_ENV !== 'production',
})
