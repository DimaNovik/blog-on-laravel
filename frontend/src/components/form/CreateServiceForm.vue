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
                                v-for="service in getNotaryServices.filter(val=>val.subgroup_id == item.id && val.text)"
                                >
                            <b-row class="mt-3 mb-3" 
                                    lg="auto"
                                    align-v="center"
                                   :key="service.value">
                                <b-col cols="12" md="8" lg="8" align-v="center">
                                    <div class="check_area"
                                    @click="selectService(service)">
                                        <span class="check_icon" 
                                                :class="{'check_icon--active': checkDisabled(service.id)}"
                                            ></span>
                                        <span class="check_text">{{service.text}}</span>
                                    </div>
                                </b-col>
                                <b-col cols="12" md="1" lg="1" align="center">
                                    <p>
                                        {{service.price }}
                                    </p>
                                </b-col>
                                <b-col align="right">
                                   <b-button 
                                   variant="primary" 
                                   @click="decrementPrice(service)"
                                   :disabled="!checkDisabled(service.id)"> - </b-button>
                                </b-col>
                                <b-col align="center">
                                   {{getSelectedCount(service.id)}}
                                </b-col>
                                <b-col align="left">
                                   <b-button 
                                   variant="primary" 
                                   @click="incrementPrice(service)"
                                   :disabled="!checkDisabled(service.id)"> + </b-button>
                                </b-col>
                            </b-row>
                        </template>
                    </b-form-group>
                </template>
            </b-col>
        </b-row>

        <div class="row mt-3 mb-5 pb-5">
            <div class="col-6 col-md-6">
                <p class="error"><b>{{error}}</b></p>
                <div class="col">
                    <b-button
                            type="submit"
                            variant="primary"
                            size="lg"
                            @click.prevent="onSubmit">
                        Зберегти
                    </b-button>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <p class="mt-5 mt-md-4" align="center">Загальна вартість: <strong>{{getTotalPrice || 0}} грн.</strong>
                </p>
            </div>
        </div>
    </form>
</template>

<script>

    import {mapGetters, mapActions, mapMutations} from 'vuex';
    import _ from 'lodash';

    export default {
        name: 'CreateServiceForm',
        data() {
            return {
                mainActions: [],
                childActions: [],
                services: [],
                selectedParentAction: null,
                selectedService: [],
                selectedPrices: [],
                selectedChild: [],
                servicesGroup: [
                    {
                        id: 1,
                        text: 'Консультації з питань'
                    },
                    {
                        id: 2,
                        text: 'Правовий аналіз документів на предмет відповідності чинному законодавству стосовно'
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
                selected0: null,
                selected1: null,
                error: '',
                options: []
            }
        },
        watch: {
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
            ...mapGetters('Calculator', ['notaryActions', 'notaryServices', 'notaryPrice', 'notaryServices']),
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
            getUserId() {
                return (this.user) ? (this.user.id < 10) ? `0${this.user.id}` : this.user.id : 0;
            },
            getRegionId() {
                return this.userGroup && this.userGroup.region_id || 0;
            },
            getGroupId() {
                return this.userGroup && this.userGroup.group_code || 0;
            },
            getTotalCount() {
                let total = 0;
                this.selectedService.forEach((item, key) => {
                    total += item.count;
                })

                return total;
            },
            getTotalPrice() {
                let total = 0;
                this.selectedService.forEach((item, key) => {
                    total += item.price * item.count;
                })

                return total.toFixed(2);
            }
        },
        methods: {
            ...mapActions('Calculator', ['getServices', 'getPrice', 'setOrder']),
            ...mapActions('Orders', ['setOrder']),
            ...mapMutations('Calculator', [
                'clearNotaryServices',
                'setNotaryPrice',
                'clearPrice',]),
            filterMain(id) {
                this.clearData();
                let data = this.notaryActions.filter(item => item.parent_id == id);
            
                if (!data.length) {
                    this.getServices({id: id, region: this.getRegionId || 1 });
                    return;
                }


                this.childActions.push(data)
            },
            filterChild(id) {

                let data = this.notaryActions.filter(item => item.parent_id == id);
                this.selectedChild.push(id);
                this.clearNotaryServices();
                this.selectedService = [];

                if (!data.length) {
                    this.getServices({
                        id:this.selectedChild[this.selectedChild.length - 1],
                        region: this.getRegionId || 1
                    });
                    return;
                }

                this.childActions.push(data)
            },
            clearData() {
                this.childActions = [];
                this.clearNotaryServices();
                this.selectedService = [];
            },
            checkDisabled(id) {
                return !!this.selectedService.some(item => item.id === id);
            },
            incrementPrice(val) {
                this.selectedService.map((item, key) => {
                    if(item.id === val.id) {
                        item.count = item.count + 1;
                    }
                })
            },
            decrementPrice(val) {
                this.selectedService.map((item, key) => {
                    if(item.id === val.id && item.count > 1) {
                        item.count = item.count - 1;
                    }
                })
            },
            getSelectedCount(id) {
                if(this.selectedService.length) {
                    let data = this.selectedService.find(item => item.id === id);                
                    return data ? data.count : 0; 
                } else {
                    return 0;
                }
            },
            onSubmit() {

                if(!this.fio.length || !this.selectedService.length) {
                    this.error = 'Заповніть необхідні поля';
                    return;
                }

                let formData = new FormData();
                let convertedServices = [];

                this.selectedService.forEach(item => {
                    convertedServices.push({
                        service: item.id,
                        count: item.count,
                        price: item.price,
                        code: this.getNotaryServices.find(value => value.id == item.id).code
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
                formData.append('count', this.getTotalCount);
                formData.append('price', this.getTotalPrice);
                formData.append('pay_date', '');
                formData.append('type', 0);
                formData.append('fio', this.fio || 'Дані не задані');
                formData.append('inn', this.inn || '');

                this.setOrder(formData).then(() => {
                    this.$router.push('/pages/calculator/main');
                    this.clearData();
                    this.error = '';
                });
            },
            selectService(val) {
                if(this.selectedService && this.selectedService.some(item => item.id === val.id)) {
                    let obj = this.selectedService.filter(item => item.id !== val.id);
                    this.selectedService = obj;
                } else {
                    this.selectedService.push({
                        id: val.id,
                        price: +val.price,
                        count: 1
                    })
                }
            }
        },
        beforeDestroy() {
            this.error = ''
        }

    }
</script>