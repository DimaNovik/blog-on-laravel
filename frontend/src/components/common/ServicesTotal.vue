<template>
    <b-row align-v="center">
        <b-col md="9" xl="10">
            <p><b>Загальна кількість:</b> {{count}} </p>
            <p>
                <a href="#">

                    <download-excel
                            :data="item"
                            :fields="json_fields"
                            name="filename.xls">

                        Завантажити дані у Excel
                        <img src="https://img.icons8.com/officexs/16/000000/ms-excel.png" class="mt-n1 ml-2"/>
                    </download-excel>
                </a></p>
            <b-row align-v="center" class="mt-5 mb-3">
                <b-col cols="md-4 lg-4">
                    <b-form-group
                            id="fieldset-1"
                            label="Період формування реєстру:"
                            label-for="input-1"
                    >
                        <b-form-select
                                v-model="selectedPeriod"
                                :options="periods"
                                @change="filterPeriod(selectedPeriod)">
                        </b-form-select>
                    </b-form-group>
                    <b-link :href="`registry-pdf-create/${getUseId}?start=${startDate}&end=${endDate}`"
                            size="sm"
                            class="btn btn-primary"
                            target="_blank"
                            :disabled="!startDate || !endDate">Сформувати реєстр
                    </b-link>
                </b-col>
            </b-row>
        </b-col>
        <b-col md="3" xl="2" align="right">
            <b-button
                    type="button"
                    variant="primary"
                    size="lg"
                    @click="handlerClick">
                Калькулятор
            </b-button>
        </b-col>
    </b-row>
</template>

<script>

    import {mapGetters} from 'vuex';
    import moment from 'moment';

    export default {
        name: "ServicesTotal",
        props: {
            item: {
                type: Array, Object,
                default() {
                    return []
                }
            },
            count: {
                type: Number, String,
                default() {
                    return 0
                }
            },
            userId: {
                type: Number,
                default() {
                    return 0
                }
            },
        },
        data() {
            return {
                json_fields: {
                    'Код дії': 'code',
                    'Загальна кількість': 'count',
                    'Вартість': 'price',
                    'Дата створення': 'created_at',
                    'Дата сплати': 'pay_date',
                    'ПІБ': 'fio',
                },
                periods: [
                    {
                        value: null,
                        text: 'Оберіть місяць' },
                    {
                        value: 0,
                        text: 'Січень'
                    },
                    {
                        value: 1,
                        text: 'Лютий'
                    },
                    {
                        value: 2,
                        text: 'Березень'
                    },
                    {
                        value: 3,
                        text: 'Квітень'
                    },
                    {
                        value: 4,
                        text: 'Травень'
                    },
                    {
                        value: 5,
                        text: 'Червень'
                    },
                    {
                        value: 6,
                        text: 'Липень'
                    },
                    {
                        value: 7,
                        text: 'Серпень'
                    },
                    {
                        value: 8,
                        text: 'Вересень'
                    },
                    {
                        value: 9,
                        text: 'Жовтень'
                    },
                    {
                        value: 10,
                        text: 'Листопад'
                    },
                    {
                        value: 11,
                        text: 'Грудень'
                    },

                ],
                startDate: null,
                endDate: null,
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
                error: '',
                selectedPeriod: null
            }
        },
        computed: {
            getUseId() {
                return this.userId ? (this.userId < 10) ? `0${this.userId}` : this.userId : 0
            }
        },
        methods: {
            handlerClick() {
                this.$router.push('/pages/calculator/create');
            },
            filterPeriod(id) {
                let countDays =moment().month(id).daysInMonth()
                this.startDate = moment().month(id).format('YYYY-MM-01');
                this.endDate = `${moment().month(id).format('YYYY-MM')}-${countDays}`;
            }
        }
    }
</script>