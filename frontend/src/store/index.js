import Vue from 'vue'
import Vuex from 'vuex'
import {state} from './state'
import * as getters from './getters'
import * as mutations from './mutations'
import * as actions from './actions'
import * as modules from './modules';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    modules
});