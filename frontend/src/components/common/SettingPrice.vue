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

        <b-row v-if="notaryServices.length && !showPrices">
            <b-col align="center">
                <b-spinner small label="Small Spinner" class="ml-3" ></b-spinner>
            </b-col>
        </b-row>

        <template v-if="notaryServices.length">
            <b-row
                   v-for="(value, j) in notaryServices"
                   :key="value.value">
                <b-col>

                    <b-row v-if="showPrices" align-v="center">
                        <b-col cols="12" md="6">
                            <b-form-group
                                    :id="`input-group-${j}`"
                                    :label="value.text"
                                    :label-for="`input-${j}`">
                                <b-form-input
                                        :id="`input-${j}`"
                                        v-model="price[value.value]"
                                        type="text"
                                        required></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col cols="12" md="6">
                            <p>
                                <b-button type="button"
                                          variant="primary"
                                          @click="handleUpdate(value.value)">
                                    Зберегти
                                </b-button>
                                <b-spinner small label="Small Spinner" class="ml-3" v-if="showSpinner && updatedId===value.value"></b-spinner>
                            </p>
                        </b-col>
                    </b-row>
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
        name: "SettingPrice",
        data() {
            return {
                selectedParentAction: null,
                childActions: [],
                selectedChild: [],
                selected0: null,
                selected1: null,
                price: [],
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
                    this.showPrices = false;

                    val.forEach(item => {
                        this.getServicePrice(item.value)
                    })
                }
            }
        },
        methods: {
            ...mapActions('Calculator', ['getMainActions', 'getServices', 'getPrice', 'priceUpdate']),
            ...mapMutations('Calculator', ['clearNotaryServices']),
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
            getServicePrice(id) {
                this.startRequest = true;
                requests.push(id);

                this.getPrice(id).then((response) => {
                    responses += 1;

                    this.price[id] = response.price;

                    if(requests.length === responses) {
                        this.showPrices = true;
                        this.startRequest = false;
                        return;
                    }
                })


            },
            clearData() {
                this.childActions = [];
                this.clearNotaryServices();
            },
            handleUpdate(id) {
                let formData = new FormData();

                formData.append('price', this.price[id]);

                this.showSpinner = true;
                this.updatedId = id;

                this.priceUpdate({id: id, data: formData}).then(() => {
                    this.showSpinner = false;
                })
            }

        },
        computed: {
            ...mapGetters('Calculator', ['notaryActions', 'notaryServices', 'priceToSetting']),
            getParentActions() {
                return this.notaryActions.filter(item => item.parent_id == 0);
            },
            getServiceCurrentPrice() {
                return this.priceToSetting.price;
            }
        },
        mounted() {
            this.getMainActions();
        }
    }
</script>