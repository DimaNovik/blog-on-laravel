import rest from '@/services/rest';

const state = () => ({
    orders: [],
});

const actions = {

    async setOrder({commit, state}, order) {
        let {data} = await rest({
            method: 'post',
            url:`notary_order`,
            data: order
        });
        return data;
    },

    async getOrders({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url:`notary_order_user/${id}`
        });

        commit('setOrders', data);
    },

    async updateOrder({commit}, params) {
        let {data} = await rest({
            method: 'post',
            url:`notary_order_update/${params.id}`,
            data: params.data
        });
    },
};

const getters = {
    orders: (state) =>  state.orders,
};

const mutations = {
    setOrders: (state, data) => {
        state.orders = data;
    },
};

export const Orders = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};