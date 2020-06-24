<template>
    <form method="post" action="#">

        <div class="row mb-3">
            <div class="col">
                <b-form-group
                    id="fieldset-1"
                    label="Оберіть пункт"
                    label-for="input-1"
                >
                    <b-form-select
                            v-model="selectedParentAction"
                            :options="getParentActions"
                            @change="filterMain(selectedParentAction)">
                        <template v-slot:first>
                            <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
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
                            label="Оберіть пункт"
                            label-for="input-1"
                    >
                        <b-form-select
                                :options="value"
                                @change="filterChild(value[key].value)">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </div>
            </div>
        </template>

        <div class="row mt-3" v-if="getNotaryServices.length">
            <div class="col">
                <template>
                    <b-form-group :label="item.text"
                                  v-for="item in servicesGroup"
                                  :key="item.text">
                        <template
                                v-for="value in getNotaryServices"
                                >
                        <b-form-radio
                                v-model="selectedService"
                                name="some-radios"
                                class="mb-2"
                                :value="value.value"
                                v-if="value.subgroup_id == item.id"
                                :key="value.value"
                                @change="servicePrice(value.value)">{{value.text}}</b-form-radio>
                        </template>
                    </b-form-group>
                </template>
            </div>
        </div>

        <div class="row mt-3" v-if="selectedService">
            <div class="col-6 col-md-6">
                <b-form-group
                        class="mb-0"
                        label="Оберіть кількість:"
                        label-for="count"
                >
                    <b-form-input
                            id="count"
                            v-model="count"
                            type="number"
                            min="1"
                            @change="changePrice(notaryCurrentPrice)"
                    ></b-form-input>
                </b-form-group>
            </div>
            <div class="col-12 col-md-6">
                <p class="mt-5 mt-md-4" align="center">Вартість послуги: <strong>{{notaryCurrentPrice}} грн.</strong></p>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <div class="col">
                <b-button
                        type="submit"
                        variant="primary"
                        @click.prevent="onSubmit">
                    Зберегти
                </b-button>
            </div>
        </div>
    </form>
</template>

<script>

    import { mapGetters, mapActions, mapMutations } from 'vuex';

    export default {
        name: 'CreateServiceForm',
        data() {
            return {
                mainActions: [],
                childActions: [],
                services: [],
                selectedParentAction: null,
                selectedService: null,
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
                count: 1,
                currentCount: 1,
                code: Math.floor(Math.random() * (999999 - 100000)) + 100000,
            }
        },
        computed: {
            ...mapGetters('Calculator', ['notaryActions', 'notaryServices', 'notaryPrice', 'notaryCurrentPrice']),
            getParentActions() {
                return this.notaryActions.filter(item => item.parent_id == 0);
            },
            getNotaryServices() {
                return this.notaryServices
            },
            getNotaryPrice() {
                return this.notaryPrice || 0
            }
        },
        methods: {
            ...mapActions('Calculator', ['getServices', 'getPrice', 'setOrder']),
            ...mapActions('Orders', ['setOrder']),
            ...mapMutations('Calculator', ['incrementPrice', 'clearNotaryServices', 'setNotaryPrice']),
            filterMain(id) {
                this.clearData();
                let data = this.notaryActions.filter(item => item.parent_id == id);

                if(!data.length) {
                    this.getServices(id);
                    return;
                }


                this.childActions.push(data)
            },
            filterChild(id) {

                let data = this.notaryActions.filter(item => item.parent_id == id);

                if(!data.length) {
                    this.getServices(this.childActions[this.childActions.length - 1][0].value);
                    return;
                }

                this.childActions.push(data)
            },
            servicePrice(id) {
                this.getPrice(id);
            },
            changePrice(price) {

                if(this.count < 1) return;

                if(this.count>= this.currentCount) {
                    let convertedPrice = Number(this.notaryPrice) + Number(price);
                    this.currentCount++;
                    this.incrementPrice(convertedPrice.toFixed(2))
                }

                if(this.count < this.currentCount) {
                    let convertedPrice = Number(price) - Number(this.notaryPrice);
                    this.currentCount--;
                    this.incrementPrice(convertedPrice.toFixed(2))
                }
            },
            clearData() {
                this.childActions = [];
                this.clearNotaryServices();
                this.selectedService = null;
                this.count = 1;
                this.currentCount = 1;
            },
            onSubmit() {

                let formData = new FormData();

                formData.append('region_id', 1);
                formData.append('office_id', '01');
                formData.append('user_id', '01');
                formData.append('action_id', this.selectedParentAction);
                formData.append('sub_action_1_id', '');
                formData.append('sub_action_2_id', '');
                formData.append('service_id', this.selectedService);
                formData.append('code', `${this.selectedParentAction}${this.selectedService}${this.code}`);
                formData.append('count', this.count);
                formData.append('price', this.notaryCurrentPrice);
                formData.append('start_date', '2020-06-22');
                formData.append('finish_date', '2020-06-22');
                formData.append('type', 1);

                this.setOrder(formData).then(()=> {
                    this.$router.push('/pages/calculator/main')
                });
            }
        }

    }
</script>