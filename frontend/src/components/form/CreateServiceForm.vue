<template>
    <form method="post" action="#">
        <div class="row mb-3">
            <div class="col col-lg-6 col-xs-4">
                <b-form-group
                        id="fieldset-2"
                        label="ПІБ замовника-платника нотаріальної послуги"
                        label-for="input-1"
                >
                    <b-form-input
                            if="input-1"
                            v-model="fio"
                            type="text"
                            required
                    />
                </b-form-group>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col col-lg-6 col-xs-4">
                <b-form-group
                        id="fieldset-4"
                        label="ІНН / Паспортні дані"
                        label-for="input-2"
                >
                    <b-form-input
                            if="input-2"
                            v-model="inn"
                            type="text"
                            required
                    />
                </b-form-group>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <b-form-group
                        id="fieldset-1"
                        label="Оберіть нотаріальну дію"
                        label-for="input-1"
                >
                    <b-form-select
                            v-model="selectedParentAction"
                            :options="getParentActions"
                            @change="filterMain(selectedParentAction)">
                        <template v-slot:first>
                            <b-form-select-option :value="null" disabled>------</b-form-select-option>
                        </template>

                    </b-form-select>
                </b-form-group>
            </div>
        </div>

        <template v-if="childActions.length">
            <div class="row mb-3"
                 v-for="(value, key) in childActions"
                 :key="key">
                <div class="col">
                    <b-form-group
                            id="`fieldset-${key}`"
                            label="Оберіть категорію нотаріальної дії"
                            label-for="select2"
                            v-if="key==0"
                    >
                        <b-form-select
                                :options="value"
                                v-model="selected0"
                                value-field="value"
                                text-field="text"
                            id="select2">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>------</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group
                            id="`fieldset2-${key}`"
                            label="Оберіть підкатегорію нотаріальної дії"
                            label-for="select3"
                            v-else
                    >
                        <b-form-select
                                :options="value"
                                v-model="selected1"
                                value-field="value"
                                text-field="text"
                                id="select3">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>----</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </div>
            </div>
        </template>

        <b-row mt="3" v-if="getNotaryServices.length">
            <b-col>
                <template>
                    <b-form-group :label="item.text"
                                  v-for="item in servicesGroup"
                                  :key="item.text">
                        <template
                                v-for="service in getNotaryServices.filter(val=>val.subgroup_id == item.id)"
                                >
                    
                            <b-row class="mt-3 mb-3" lg="auto"
                                   :key="service.value">
                                <b-col cols="5" md="9" lg="9">
                                    <label :for="service.value"
                                    >
                                        <b-form-checkbox-group
                                                v-model="selectedService"
                                                :options="getCheckboxOptions(service)"
                                                :name="getNotaryServices.value"
                                                :value-field="getNotaryServices.value"
                                                stacked
                                        ></b-form-checkbox-group>
                                    </label>
                                </b-col>
                                <b-col cols="2" md="1" lg="1">
                                    <p>
                                        {{service[`price_region_${getRegionId}`]}}
                                    </p>
                                </b-col>
                                <b-col cols="5" md="2" lg="2">
                                    <b-form-spinbutton
                                            :id="'service.value'"
                                            size="sm"
                                            min="1"
                                            :value="service.choosed"
                                            :disabled="!checkDisabledSpin(service.value) || isLoading"
                                            ref="spin"
                                            :data-id="service.value"
                                            @change="setCount(service.value, $event)"
                                          ></b-form-spinbutton>
                                </b-col>
                            </b-row>
                        </template>
                    </b-form-group>
                </template>
            </b-col>
        </b-row>

        <div class="row mt-3 mb-5">
            <div class="col-6 col-md-6">
                <p class="error"><b>{{error}}</b></p>
                <div class="col">
                    <b-button
                            type="submit"
                            variant="primary"
                            size="lg"
                            @click.prevent="onSubmit"
                            :disabled="isLoading">
                        Зберегти
                    </b-button>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <p class="mt-5 mt-md-4" align="center">Загальна вартість: <strong>{{getNotaryPrice || 0}} грн.</strong>
                </p>
            </div>
        </div>
    </form>
</template>

<script>

    import {mapGetters, mapActions, mapMutations} from 'vuex';

    export default {
        name: 'CreateServiceForm',
        data() {
            return {
                mainActions: [],
                childActions: [],
                services: [],
                selectedParentAction: null,
                selectedService: [],
                selectedChild: [],
                servicesGroup: [
                    {
                        id: 1,
                        text: 'Консультації з питань'
                    },
                    {
                        id: 2,
                        text: 'Правовий аналіз документів на  предмет відповідності чинному законодавству стосовно'
                    },
                    {
                        id: 3,
                        text: 'Послуги технічного характеру'
                    },
                    {
                        id: 4,
                        text: 'Інші послуги'
                    },
                    {
                        id: 5,
                        text: 'Послуги, які надаються державним нотаріальним архівом  як архівною установою'
                    }
                ],
                fio: '',
                inn: '',
                count: 0,
                selected0: null,
                selected1: null,
                error: '',
                isLoading: false
            }
        },
        watch: {
            'selectedService': {
                immediate: false,
                handler(newVal, oldVal) {
    
                    if(newVal.length === 0) {
                        this.clearPrice();
                    } else if(newVal.length === this.selectedService.length && newVal.length > oldVal.length) {
                        this.servicePrice({id: newVal.slice(-1), region: this.getRegionId});
                        this.setCount(newVal.slice(-1), 1);
                    } else {
                        let serviceId;

                        for (var i = 0; i < oldVal.length; i++) {
                            if (newVal.indexOf(oldVal[i]) === -1) {
                                serviceId = oldVal[i];
                            }
                        }
                        this.resetCount(serviceId);
                        this.decrementSelectedPrice(serviceId)
                    }
                }
            },
            'selected0': {
                immediate: false,
                handler(newVal, oldVal) {

                    if(newVal !== oldVal) {
                        this.childActions.splice(1);
                    }

                    this.filterChild(newVal);
                }
            },
            'selected1': {
                immediate: false,
                handler(id) {
                    this.filterChild(id);
                }
            }
        },
        computed: {
            ...mapGetters('Calculator', ['notaryActions', 'notaryServices', 'notaryPrice', 'selectedPrices', 'notaryServices']),
            ...mapGetters('User', ['user','userGroup']),
            getParentActions() {
                return this.notaryActions.filter(item => item.parent_id == 0);
            },
            getNotaryServices() {
                return this.notaryServices
            },
            getNotaryPrice() {
                return this.notaryPrice || 0
            },
            getRandomCode() {
                return Math.floor(Math.random() * (999999 - 100000)) + 100000;
            },
            getServicesCount() {
                let arr = [];

                this.notaryServices.forEach(item => {
                    if(item.choosed > 0) {
                        arr.push( item.choosed)
                    }

                })

                return arr.reduce((a, b) => a+b, 0)
            },
            getUserId() {
                return (this.user) ? (this.user.id < 10) ? `0${this.user.id}` : this.user.id : 0;
            },
            getRegionId() {
                return this.userGroup && this.userGroup.region_id || 0;
            },
            getGroupId() {
                return this.userGroup && this.userGroup.group_code || 0;
            }
        },
        methods: {
            ...mapActions('Calculator', ['getServices', 'getPrice', 'setOrder']),
            ...mapActions('Orders', ['setOrder']),
            ...mapMutations('Calculator', [
                'incrementPrice',
                'decrementPrice',
                'clearNotaryServices',
                'setNotaryPrice',
                'changeSelectedPriceCount',
                'clearPrice',
                'decrementSelectedPrice',
                'choosedCount']),
            filterMain(id) {
                this.clearData();
                let data = this.notaryActions.filter(item => item.parent_id == id);

                if (!data.length) {
                    this.getServices(id);
                    return;
                }


                this.childActions.push(data)
            },
            filterChild(id) {

                let data = this.notaryActions.filter(item => item.parent_id == id);
                this.selectedChild.push(id);
                this.clearNotaryServices();

                if (!data.length) {
                    this.getServices(this.selectedChild[this.selectedChild.length - 1]);
                    return;
                }

                this.childActions.push(data)
            },
            servicePrice(id) {
                this.isLoading = true;

                this.getPrice(id).then(()=> {
                    this.isLoading = false;
                    this.checkDisabledSpin(id)
                });
            },

            clearData() {
                this.childActions = [];
                this.clearNotaryServices();
                this.selectedService = [];
            },
            onSubmit() {

                if(!this.fio.length || !this.selectedService.length) {
                    this.error = 'Заповніть необхідні поля';
                    return;
                }

                let formData = new FormData();
                let convertedServices = [];

                this.isLoading = true;

                this.selectedPrices.map(item => {
                    convertedServices.push({
                        service: item.service,
                        count: item.count,
                        price: item.price,
                        code: this.getNotaryServices.find(value => value.id == item.service).code
                    })
                });

                formData.append('region_id', this.getRegionId);
                formData.append('office_id', this.getGroupId);
                formData.append('user_id', this.getUserId);
                formData.append('action_id', +this.selectedParentAction);
                formData.append('sub_action_1_id', +this.selectedChild[0] || '');
                formData.append('sub_action_2_id', +this.selectedChild[1] || '');
                formData.append('service_id', JSON.stringify(convertedServices));
                formData.append('code', `A${this.getRegionId}${this.getGroupId}${this.getUserId}-${this.getRandomCode}`);
                formData.append('count', this.getServicesCount);
                formData.append('price', this.notaryPrice);
                formData.append('pay_date', '');
                formData.append('type', 0);
                formData.append('fio', this.fio || 'Дані не задані');
                formData.append('inn', this.inn || '');

                this.setOrder(formData).then(() => {
                    this.$router.push('/pages/calculator/main');
                    this.clearData();
                    this.error = '';
                    this.isLoading = false;
                });
            },
            getCheckboxOptions(val) {
                let arr = [];
            
                arr.push({
                    text: val[`text_region_${this.getRegionId}`],
                    value: val.value
                })

                return arr;
            },
            setCount(service, val) {

                this.choosedCount({id: service, count: val});

                for(let i=0; i< this.selectedPrices.length; i++) {

                    if(this.selectedPrices[i].service == service) {

                        if(this.selectedPrices[i].count == 1 && val == 1) return;
                        if(this.selectedPrices[i].count < val) {
                            this.incrementPrice(this.selectedPrices[i].price);
                            this.selectedPrices[i].count = val
                        } else {
                            this.decrementPrice(this.selectedPrices[i].price);
                            this.selectedPrices[i].count = val;
                        }
                    }


                }

            },
            resetCount(id) {
                let { spin } = this.$refs;

                for(let i=0; i< spin.length; i++) {
                    if(spin[i].$attrs['data-id'] == id) {
                        spin[i].$el.value= 1
                    }
                }
            },
            checkDisabledSpin(id) {
                if(this.selectedService) {
                    return this.selectedService.includes(id)
                }

            },
        },
        beforeDestroy() {
            this.error = ''
        }

    }
</script>