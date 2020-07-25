import rest from '@/services/rest';

const state = () => ({
    groups: [],
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
            url:`register`,
            data: formData
        });

        return data;
    },

    async loginUser({commit}, formData) {
        let {data} = await rest({
            method: 'post',
            url:`user/login`,
            data: formData
        });

        return data;
    },

};

const getters = {
    groups: (state) =>  state.groups,
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

};

export const User = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};