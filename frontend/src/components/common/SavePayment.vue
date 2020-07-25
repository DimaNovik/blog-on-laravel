<template>
    <div class="invoice"
         :class="{'active': isActive}">
        <b-form @submit.prevent="savePayment">
            <b-row>
                <b-col xl="10">
                    <p>Оплата дії: <b>{{getCode}}</b></p>
                    <p>ПІБ: <b>{{getFio}}</b></p>
                </b-col>
                <b-col>
                    <a href="#"
                       class="close"
                       @click="hide">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 26.7 26.6" style="enable-background:new 0 0 26.7 26.6;" xml:space="preserve">
    <polygon class="st0" stroke="#000000" stroke-width="0.75" stroke-miterlimit="10" points="26.1,2 24.7,0.5 13.3,11.8 2,0.5 0.5,2 11.9,13.3 0.5,24.6 2,26.1 13.3,14.8 24.7,26.1 26.1,24.6
        14.8,13.3 "/>
    </svg>
                    </a>
                </b-col>
            </b-row>
            <b-row class="mt-3">
                <b-col>
                    <b-form-group
                            id="fieldset-1"
                            label="Номер квитанції"
                            label-for="input-1"
                    >
                        <b-form-input
                                if="input-1"
                                v-model="invoice"
                                type="text"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group
                            id="fieldset-2"
                            label="Дата оплати"
                            label-for="invoice-date"
                    >
                        <b-form-datepicker
                                id="invoice-date"
                                v-model="paymentDate"
                                :locale="locale"
                                v-bind="labels[locale] || {}"
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                        ></b-form-datepicker>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row v-if="error">
                <b-col>
                    <p class="error">{{error}}</p>
                </b-col>
            </b-row>
            <b-row class="mt-3">
                <b-col align="center">
                    <b-button
                            type="submit"
                            variant="primary">Зберегти
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>

    import {mapActions} from 'vuex';
    import moment from 'moment';

    export default {
        name: "SavePayment",
        props: {
            item: {
                type: Object,
                default() {
                    return {}
                },
            },
            isActive: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                locale: 'ua',
                labels: {
                    ua: {
                        labelPrevDecade: 'Попереднє десятиліття',
                        labelPrevYear: 'Попередній рік',
                        labelPrevMonth: 'Минулий місяць',
                        labelCurrentMonth: 'Поточний місяць',
                        labelNextMonth: 'Наступного місяця',
                        labelNextYear: 'Наступного року',
                        labelNextDecade: 'Наступне десятиліття',
                        labelToday: 'Сьогодні',
                        labelSelected: 'Вибрана дата',
                        labelNoDateSelected: 'Оберіть дату',
                        labelCalendar: 'Календар',
                        labelNav: 'Навігація по календару',
                        labelHelp: 'Використовуйте клавіші зі стрілками для навігації по календару'
                    },
                },
                invoice: null,
                paymentDate: null,
                type: 1,
                error: ''
            }
        },
        computed: {
            getCode() {
                return this.item ? this.item.code : ''
            },
            getFio() {
                return this.item ? this.item.fio : ''
            },
            getCurrentTime() {
                return moment().format('HH:MM:ss');
            },
        },
        methods: {
            ...mapActions('Orders', ['updateOrder']),
            savePayment() {

                let momentDiff = moment(this.paymentDate).diff(this.item.create, 'days');

                if(!this.invoice || !this.paymentDate) {
                    this.error = 'Заповніть усі поля'
                } else if(momentDiff < 0) {
                    this.error = 'Дата оплати менша за дату створення'
                } else {

                    let formData = new FormData();

                    formData.append('invoice', this.invoice);
                    formData.append('pay_date', this.paymentDate + ' ' + this.getCurrentTime);
                    formData.append('type', this.type);

                    this.updateOrder({id: this.item.id, data: formData}).then(() => {
                        this.$emit('showPopup');
                        this.invoice = null;
                        this.paymentDate = null;
                        this.error = ''
                    })
                }
            },
            hide() {
                this.$emit('showPopup');
                this.invoice = null;
                this.paymentDate = null;
                this.error = ''
            }
        }
    }
</script>