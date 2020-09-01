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
            <b-row align-v="center" class="mt-3 mb-3">
                <b-col xl="4" md="6">
                    <b-form-group
                            id="fieldset-1"
                            label="Реєстр з:"
                            label-for="invoice-date-start"
                    >
                        <b-form-datepicker
                                id="invoice-date-start"
                                v-model="startDate"
                                :locale="locale"
                                v-bind="labels[locale] || {}"
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                        ></b-form-datepicker>
                    </b-form-group>

                    <b-form-group
                            id="fieldset-2"
                            label="Реєстр по:"
                            label-for="invoice-date-end"
                    >
                        <b-form-datepicker
                                id="invoice-date-end"
                                v-model="endDate"
                                :locale="locale"
                                v-bind="labels[locale] || {}"
                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                        ></b-form-datepicker>
                    </b-form-group>
                </b-col>
                <b-col>
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
                    @click="handlerClick">
                Калькулятор
            </b-button>
        </b-col>
    </b-row>
</template>

<script>

    import {mapGetters} from 'vuex';

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
                error: ''
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
        }
    }
</script>