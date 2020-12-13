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

    async getServices({commit}, id) {
        let {data} = await rest({
            method: 'get',
            url:`notary_services/${id}`
        });
        commit('setNotaryServices', data);
    },

    async getPrice({commit}, params) {

        let {data} = await rest({
            method: 'get',
            url:`notary_service_price/${params.id[0]}`
        });

        commit('setNotaryPrice',{payload: data, region: params.region});

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

    setNotaryServices: (state, data) => {
        let convertData = [];
      
        for(let i=0; i<data.length; i++) {
            for(let j=0, length = state.allPrices.length; j<length; j++) {

                if(data[i].id === state.allPrices[j].id) {
                    convertData.push({
                        id: data[i].id,
                        text_region_1: data[i].name,
                        text_region_2: data[i].name_mik,
                        text_region_3: data[i].name_kher,
                        value: data[i].id,
                        parent_id: data[i].parent_id,
                        subgroup_id: data[i].subgroup_id,
                        choosed: 0,
                        code: data[i].code,
                        price_region_1: state.allPrices[j].price,
                        price_region_2: state.allPrices[j].price_mik,
                        price_region_3: state.allPrices[j].price_kher
                    })
                }
            }

        }

        state.notaryServices = convertData;
    },

    setNotaryPrice: (state, data) => {
      
        if(data.region === 1) {
            state.price += Number(data.payload.price) || 0;
            state.selectedPrices.push({
                service: data.payload.service_id,
                price: data.payload.price,
                count: 1,
            });
        } else if(data.region === 2) {
            state.price += Number(data.payload.price_mik) || 0;
            state.selectedPrices.push({
                service: data.payload.service_id,
                price: data.payload.price_mik,
                count: 1,
            });
        } else {
            state.price += Number(data.payload.price_kher) || 0;
            state.selectedPrices.push({
                service:data.payload.service_id,
                price: data.payload.price_kher,
                count: 1,
            });
        }
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
        state.selectedPrices = state.selectedPrices.filter(item => item.service != id);
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