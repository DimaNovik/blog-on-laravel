import rest from '@/services/rest';

const state = () => ({
    notaryActions: [],
    notaryServices: [],
    price: null,
    selectedPrices: [],
    moreInfo: {
        name: '',
        list: []
    }
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

        return data;
    },

    async getOnceAction({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url: `notary_once_action/${id}`
        });

        commit('setMoreInfoName', data)
    },


    async getOnceService({commit}, params) {
        let {data} = await rest({
            method: 'get',
            url: `notary_once_service/${params.id}`
        });

        commit('setMoreInfo', {name: data.name, count: params.count})
    },

    async priceUpdate({commit}, params) {
        let {data} = await rest({
            method: 'post',
            url:`notary_price_update/${params.id}`,
            data: params.data
        });
    },

};

const getters = {
    notaryActions: (state) =>  state.notaryActions,
    notaryServices: (state) =>  state.notaryServices,
    notaryPrice: (state) =>  state.price && state.price.toFixed(2),
    selectedPrices: (state) =>  state.selectedPrices,
    moreInfo: (state) =>  state.moreInfo,
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
                subgroup_id: data[i].subgroup_id,
                choosed: 0,
            })
        }

        state.notaryServices = convertData;
    },

    setNotaryPrice: (state, data) => {
        state.price += Number(data.price) || 0;
        state.selectedPrices.push({
            service: data.service_id,
            price: data.price,
            count: 1,
        });
    },

    incrementPrice: (state, price) => {
        state.price = +state.price + Number(price);
    },

    decrementPrice: (state, price) => {
        state.price = +state.price - Number(price);
    },

    clearNotaryServices: (state) => {
        state.notaryServices = [];
        state.price = null;
        state.selectedPrices = [];
    },

    clearPrice: (state) => {
        state.price = null;
        state.selectedPrices = [];
        state.notaryServices.forEach(item => item.choosed = 0)
    },

    decrementSelectedPrice: (state, id) => {
        let deletedService = state.selectedPrices.find(item => item.service == id);
        let newPrice = +deletedService.price * deletedService.count;
        deletedService.count = 1;
        state.price = +state.price - Number(newPrice);
        state.notaryServices.find(item => item.value == id).choosed = 0;
    },

    choosedCount: (state, data) => {
        state.notaryServices.find(item => item.value == data.id).choosed = data.count;

    },

    setMoreInfoName: (state, data) => {
        state.moreInfo.name = data.name;
    },

    setMoreInfo: (state, data) => {
        state.moreInfo.list.push(data)
    },

    clearMoreInfo: (state, data) => {
        state.moreInfo.name = '';
        state.moreInfo.list = [];
    },

};

export const Calculator = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};