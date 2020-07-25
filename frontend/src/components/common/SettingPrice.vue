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
                            @change="filterMain(selectedParentAction)">
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
                                v-if="key==0">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                            </template>
                        </b-form-select>

                        <b-form-select
                                :options="value"
                                v-model="selected1"
                                value-field="value"
                                text-field="text"
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
            <b-row>
                <b-col>
                    <b-form-group
                            id="fieldset-2"
                            label="Оберіть пункт"
                            label-for="input-1"
                    >
                        <b-form-select
                                v-model="selectedService"
                                :options="notaryServices"
                                @change="getPrice(selectedService)">
                            <template v-slot:first>
                                <b-form-select-option :value="null" disabled>-- Оберіть дію --</b-form-select-option>
                            </template>

                        </b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
        </template>
        {{price}}
{{priceToSetting}}
        <template v-if="price">
            <b-row>
                <b-col>
                    <b-form-group
                            id="input-group-1"
                            label="Вартість послуги"
                            label-for="input-1">
                        <b-form-input
                                id="input-1"
                                v-model="price"
                                type="text"
                                required></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
        </template>

        <b-row class="mt-4">
            <b-col>
                <b-button type="submit"
                        variant="primary">
                    Зберегти
                </b-button>
            </b-col>
        </b-row>
    </form>
</template>

<script>

    import { mapGetters, mapActions, mapMutations } from 'vuex';

    export default {
        name: "SettingPrice",
        data() {
            return {
                selectedParentAction: null,
                selectedService: null,
                childActions: [],
                selectedChild: [],
                selected0: null,
                selected1: null,
                price: null
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
        methods: {
            ...mapActions('Calculator', ['getMainActions', 'getServices', 'getPrice']),
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
                this.getPrice(id).then((response)=> {
                    console.log(response);
                    this.price = this.getServiceCurrentPrice();
                })
            },
            clearData() {
                this.childActions = [];
                this.selectedService = [];
                this.clearNotaryServices();
            },
        },
        computed: {
            ...mapGetters('Calculator', ['notaryActions','notaryServices', 'priceToSetting']),
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