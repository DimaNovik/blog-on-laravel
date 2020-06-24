import rest from '@/services/rest';

const state = () => ({
    notaryActions: [],
    notaryServices: [],
    price: null,
    currentPrice: null
});

const actions = {

    async getMainActions({commit}) {
        let {data} = await rest({
            method: 'get',
            url:'notary_actions'
        });

        commit('setNotaryActions', data);
        commit('clearNotaryServices', []);
    },

    async getServices({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url:`notary_services/${id}`
        });
        commit('setNotaryServices', data);
    },

    async getPrice({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url:`notary_service_price/${id}`
        });

        commit('setNotaryPrice', data);
    },
};

const getters = {
    notaryActions: (state) =>  state.notaryActions,
    notaryServices: (state) =>  state.notaryServices,
    notaryPrice: (state) =>  state.price,
    notaryCurrentPrice: (state) =>  state.currentPrice,
};

const mutations = {
    setNotaryActions: (state, data) => {
        let convertData = [];
        for(let i=0; i<data.length; i++) {
            convertData.push({
                text: data[i].name,
                value: data[i].id,
                parent_id: data[i].parent_id,
                code: data[i].code
            })
        }
        state.notaryActions = convertData;
    },

    setNotaryServices: (state, data) => {
        let convertData = [];
        for(let i=0; i<data.length; i++) {
            convertData.push({
                text: data[i].name,
                value: data[i].id,
                parent_id: data[i].parent_id,
                subgroup_id: data[i].subgroup_id
            })
        }

        state.notaryServices = convertData;
    },

    setNotaryPrice: (state, data) => {
        state.price = data.price || 0;
        state.currentPrice = data.price || 0;
    },

    incrementPrice: (state, price) => {
        state.currentPrice = Number(price);
    },

    clearNotaryServices: (state) => {
        state.notaryServices = [];
    }
};

export const Calculator = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};