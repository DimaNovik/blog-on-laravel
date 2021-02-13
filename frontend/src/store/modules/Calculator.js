import rest from '@/services/rest';

const state = () => ({
    notaryActions: [],
    notaryServices: [],
    price: null,
    selectedPrices: [],
    moreInfo: {
        name: '',
        list: []
    },
    allPrices: [],
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

    async getServices({commit}, params) {
        let {data} = await rest({
            method: 'get',
            url:`notary_services/${params.id}`
        });

        commit('setNotaryServices', {data: data, region: params.region});
    },

    async getPrice({commit}, params) {
    
        let {data} = await rest({
            method: 'get',
            url:`notary_service_price/${params.id}`
        });

        commit('setNotaryPrice', {data: data, region: params.region});

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

    async serviceUpdate({commit}, params) {
        let {data} = await rest({
            method: 'post',
            url:`service_update/${params.id}`,
            data: params.data
        });
    },

    async codeUpdate({commit}, params) {
        let {data} = await rest({
            method: 'post',
            url:`notary_code_update/${params.id}`,
            data: params.data
        });
    },

    async getAllPrice({commit}) {
        let {data} = await rest({
            method: 'get',
            url: `notary_all_prices`
        });
      
        commit('setAllPrices', data)
    },



};

const getters = {
    notaryActions: (state) =>  state.notaryActions,
    notaryServices: (state) =>  state.notaryServices,
    notaryPrice: (state) =>  state.price && state.price.toFixed(2),
    selectedPrices: (state) =>  state.selectedPrices,
    moreInfo: (state) =>  state.moreInfo,
    allPrices: (state) =>  state.allPrices,
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

    setNotaryServices: (state, params) => {
        let convertData = [];
        console.log(params);
        for(let i=0; i< params.data.length; i++) {
            for(let j=0, length = state.allPrices.length; j<length; j++) {

                if(params.data[i].id === state.allPrices[j].id) {
                    convertData.push({
                        id: params.data[i].id,
                        text: params.region == 1 ? params.data[i].name : params.data[i].name_kher,
                        value: params.data[i].id,
                        parent_id: params.data[i].parent_id,
                        subgroup_id: params.data[i].subgroup_id,
                        choosed: 0,
                        code: params.region == 1 ? params.data[i].code : params.data[i].code_kher,
                        price:  params.region == 1 ? +state.allPrices[j].price : +state.allPrices[j].price_kher,
                    })
                }
            }

        }

        state.notaryServices = convertData;
    },

    setNotaryPrice: (state, params) => {
        state.price += Number(params.region == 1 ? params.data.price : params.data.price_kher) || 0;
        state.selectedPrices.push({
            service: params.data.service_id,
            price: params.region == 1 ? +params.data.price : +params.data.price_kher,
            count: 1,
        });
    },

    incrementPrice: (state, price) => {
        state.price = state.price + price;
    },

    decrementPrice: (state, price) => {
        state.price = state.price - price;
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
        let newPrice = deletedService.price * deletedService.count;
        deletedService.count = 1;
        state.selectedPrices = state.selectedPrices.filter(item => item.service != id);
        state.price = state.price - newPrice;
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

    setAllPrices: (state, data) => {
        state.allPrices = data;
    },

};

export const Calculator = {
    namespaced: true,
    state,
    actions,
    getters,
    mutations,
};