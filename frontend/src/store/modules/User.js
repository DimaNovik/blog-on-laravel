import rest from '@/services/rest';
import Cookies from "js-cookie";

const state = () => ({
    groups: [],
    user: null,
    userGroup: null
});

const actions = {

    async getGroups({commit}) {
        let {data} = await rest({
            method: 'get',
            url:`notary_groups`
        });

        commit('setGroups', data);
    },

    async regUser({commit}, formData) {
        let {data} = await rest({
            method: 'post',
            url:`auth/register`,
            data: formData
        });

        return data;
    },

    async loginUser({commit}, formData) {

        let {data} = await rest({
            method: 'post',
            url:`auth/login`,
            data: formData,
        });

        Cookies.set('access_token', data.access_token);

        return data;
    },

    async checkUser({commit}) {

        let {data} = await rest({
            method: 'post',
            url:`auth/me`,
        });

        commit('setUser', data)

        return data;
    },

    async userGroup({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url:`user_group/${id}`
        });

        commit('setUserGroup', data);
    },

    async logout({commit}) {

        let {data} = await rest({
            method: 'post',
            url:`auth/logout`,
        });

        commit('clearUser');
        Cookies.remove('access_token');

        return data;
    },

};

const getters = {
    groups: (state) =>  state.groups,
    user: (state) =>  state.user,
    userGroup: (state) =>  state.userGroup,
};

const mutations = {
    setGroups: (state, data) => {

        let convertData = [];
        for(let i=0; i<data.length; i++) {
            convertData.push({
                text: data[i].name,
                value: data[i].id,
            })
        }
        state.groups = convertData;
    },

    setUser: (state, data) => {
        state.user = data
    },

    setUserGroup: (state, data) => {
        state.userGroup = data
    },

    clearUser: (state) => {
        state.user = null,
        state.userGroup = null
    }

};

export const User = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};