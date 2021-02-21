import rest from '@/services/rest';

const state = () => ({
    orders: [],
    allOrders: [],
    allUsers: null
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

    async deleteOrder({commit}, id) {
        let {data} = await rest({
            method: 'delete',
            url:`delete_order/${id}`,
        });
    },

    async getAllOrders({commit}) {
        let {data} = await rest({
            method: 'get',
            url:`notary_all_orders`
        });

        commit('setAllOrders', data);
    },

    async getAllUsers({commit}) {
        let {data} = await rest({
            method: 'get',
            url:`all_users`
        });
    
        commit('setUsers', data);
        commit('updateAllOrders', data);
    },

    async getGroupScore({commit}, params) {
        let {data} = await rest({
            method: 'post',
            url:`/pages/calculator/group_score`,
            data: params
        });

        return data;
    },
};

const getters = {
    orders: (state) =>  state.orders,
    allOrders: (state) =>  state.allOrders,
    allUsers: (state) =>  state.allUsers
};

const mutations = {
    setOrders: (state, data) => {
        state.orders = data;
    },

    setAllOrders: (state, data) => {
        state.allOrders = data;
    },

    setUsers: (state, data) => {
        state.allUsers = data;
    },

    updateAllOrders: (state, data) => {

        for(let i=0, length = state.allOrders.length; i<length; i++) {
            for(let j=0, length = data.length; j<length; j++) {
                if(state.allOrders[i].user_id == data[j].id) {
                    state.allOrders[i].name = data[j].name;
                }
            }
        }
    },
};

export const Orders = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};