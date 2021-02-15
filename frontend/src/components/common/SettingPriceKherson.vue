<template>
    <form action="#">
        <b-row class="mb-3">
            <b-col>
                <b-form-group
                        id="fieldset-1"
                        label="Оберіть пункт"
                        label-for="input-1"
                >
                    <b-form-select
                            v-model="selectedParentAction"
                            :options="getParentActions"
                            @change="filterMain(selectedParentAction)"
                            :disabled="startRequest">
                        <template v-slot:first>
                            <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                        </template>

                    </b-form-select>
                </b-form-group>
            </b-col>
        </b-row>

        <template v-if="childActions.length">
            <b-row class="mb-3"
                   v-for="(value, key) in childActions"
                   :key="key">
                <b-col>
                    <b-form-group
                            id="`fieldset-${key}`"
                            label="Оберіть пункт"
                            label-for="input-1"
                    >
                        <b-form-select
                                :options="value"
                                v-model="selected0"
                                value-field="value"
                                text-field="text"
                                v-if="key==0"
                                :disabled="startRequest">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                            </template>
                        </b-form-select>

                        <b-form-select
                                :options="value"
                                v-model="selected1"
                                value-field="value"
                                text-field="text"
                                :disabled="startRequest"
                                v-else>
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
        </template>

        <template v-if="notaryServices.length">
            <b-row
                   v-for="(value, j) in notaryServices"
                   :key="value.value * j">
                <b-col  v-if="name[value.value] && name[value.value].length">
                    <b-row  align-v="center">
                        <b-col cols="12" md="6">
                            <b-form-group
                                    :id="`input-group-${value.value + j}`"
                                    :label="`Редагувати дані для коду: ${code[value.value]}`"
                                    :label-for="`input-${value.value + j}`"
                                    >
                                <b-form-input
                                        :id="`input-${value.value + j}`"
                                        v-model="code[value.value]"
                                        type="text"
                                        required
                                        placeholder="Код дії"
                                        class="mb-3"/>
                                 <b-form-textarea
                                    v-model="name[value.value]"
                                    type="text"
                                    required
                                    class="mb-3" />
                                <b-form-input
                                        :id="`input-${value.value + j}`"
                                        v-model="price[value.value]"
                                        type="text"
                                        required
                                        class="mb-1"/>
                            </b-form-group>
                        </b-col>
                        <b-col cols="12" md="6">
                          <p class="mb-3">
                                <b-button type="button"
                                          variant="primary"
                                          @click="handleUpdateCode(value.value)">
                                    Зберегти код
                                </b-button>

                            </p>
                            <p class="mb-3">
                                <b-button type="button"
                                          variant="primary"
                                          @click="handleServiceUpdate(value.value)">
                                    Зберегти назву
                                </b-button>

                            </p>
                            <p class="mb-3">
                                <b-button type="button"
                                          variant="primary"
                                          @click="handleUpdate(value.value)">
                                    Зберегти вартість
                                </b-button>
                                <b-spinner small label="Small Spinner" class="ml-3" v-if="showSpinner && updatedId===value.value"></b-spinner>
                            </p>
                        </b-col>
                    </b-row>
                    <hr />
                </b-col>
            </b-row>
        </template>
    </form>
</template>

<script>

    import {mapGetters, mapActions, mapMutations} from 'vuex';

    let requests = [];
    let responses = 0;
    export default {
        name: "SettingPriceKherson",
        data() {
            return {
                selectedParentAction: null,
                childActions: [],
                selectedChild: [],
                selected0: null,
                selected1: null,
                price: [],
                name: [],
                code: [],
                startRequest: false,
                showPrices: false,
                showSpinner: false,
                updatedId: null,
            }
        },
        watch: {
            'selected0': {
                immediate: false,
                handler(newVal, oldVal) {

                    if (newVal !== oldVal) {
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
            },
            'notaryServices': {
                immediate: false,
                handler(val) {

                    requests = [];
                    responses = 0;
                
                    val.forEach(item => {
                        this.getServicePrice(item.value);
                        this.setNameModel(item);
                        this.setCodeModel(item);
                    })
                }
            }
        },
        methods: {
            ...mapActions('Calculator', ['getMainActions', 'getServices', 'getPrice', 'priceUpdate', 'serviceUpdate', 'getAllPrice', 'codeUpdate']),
            ...mapMutations('Calculator', ['clearNotaryServices']),
            filterMain(id) {
                this.clearData();
                let data = this.notaryActions.filter(item => item.parent_id == id);

                if (!data.length) {
                    this.getServices({id: id, region: 2});
                    return;
                }

                this.childActions.push(data)
            },
            filterChild(id) {

                let data = this.notaryActions.filter(item => item.parent_id == id);
                this.selectedChild.push(id);
                this.clearNotaryServices();

                if (!data.length) {
                    this.getServices({
                        id: this.selectedChild[this.selectedChild.length - 1],
                        region: 2
                    });
                    return;
                }

                this.childActions.push(data)
            },
            getServicePrice(id) {
                for(let i=0, length = this.allPrices.length; i<length; i++) {
                    if(this.allPrices[i].service_id == id) {
                        this.price[id] = this.allPrices[i].price_kher;
                    }
                }
            },
            clearData() {
                this.childActions = [];
                this.clearNotaryServices();
            },
            handleUpdate(id) {
                let formData = new FormData();

                formData.append('price_kher', this.price[id]);

                this.showSpinner = true;
                this.updatedId = id;

                this.priceUpdate({id: id, data: formData}).then(() => {
                    this.showSpinner = false;
                    this.getAllPrice();
                })
            },
            handleServiceUpdate(id) {
                let formData = new FormData();

                formData.append('name_kher', this.name[id]);

                this.showSpinner = true;
                this.updatedId = id;

                this.serviceUpdate({id: id, data: formData}).then(() => {
                    this.showSpinner = false;
                })
            },
            handleUpdateCode(id) {
                let formData = new FormData();
              
                formData.append('code_kher', this.code[id]);

                this.showSpinner = true;
                this.updatedId = id;

                this.codeUpdate({id: id, data: formData}).then(() => {
                    this.showSpinner = false;
                })
            },
            setNameModel(val) {
                if(val.text.length) {
                  this.name[val.value] = val.text;
                }
                
            },
            setCodeModel(val) {
                if(val.code.length) {
                  this.code[val.value] = val.code
                }

            },

        },
        computed: {
            ...mapGetters('Calculator', ['notaryActions', 'notaryServices', 'priceToSetting', 'allPrices']),
            getParentActions() {
                return this.notaryActions.filter(item => item.parent_id == 0);
            },
            getServiceCurrentPrice() {
                return this.priceToSetting.price;
            }
        },
        mounted() {
            this.getMainActions().then(()=> {
                this.getAllPrice();
            });
        },
    }
</script>