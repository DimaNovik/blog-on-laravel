<template>
    <b-row align-v="center">
        <b-col>
            <b-row>
                <b-col md="4" xl="4">
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
                </b-col>
            </b-row>
            <b-row align-v="center">
                <b-col md="12" lg="4" xl="4">
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
                    <b-row>
                        <b-col>
                            <b-link :href="`registry-pdf-create/${getUseId}?start=${startDate}&end=${endDate}`"
                                    size="sm"
                                    class="btn btn-primary"
                                    target="_blank"
                                    :disabled="!startDate || !endDate">Реєстр нотаріуса
                            </b-link>
                        </b-col>
                    
                        <b-col v-if="role == 2">
                            <b-link :href="`registry-group-pdf-create/${group.group_code}?region=${group.region_id}&start=${startDate}&end=${endDate}`"
                                    size="sm"
                                    class="btn btn-primary"
                                    target="_blank"
                                    :disabled="!startDate || !endDate">Реєстр контори
                            </b-link>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="12" lg="6" xl="4">
                    <b-form-group
                            id="fieldset-3"
                            label="Період формування звіту про роботу:"
                            label-for="input-1"
                    >
                        <b-form-select
                                v-model="selectedPeriodZvit"
                                :options="periodsZvit"
                                @change="filterZvitPeriod(selectedPeriodZvit)">
                        </b-form-select>
                    </b-form-group>
                    <b-row>
                        <b-col>
                            <b-link :href="`create_total_score_pdf/${getUseId}?start=${startZvitDate}&end=${endZvitDate}`"
                                    size="sm"
                                    class="btn btn-primary"
                                    target="_blank"
                                    :disabled="!startZvitDate || !endZvitDate">Звіт нотаріуса
                            </b-link>
                        </b-col>
                       
                        <b-col v-if="role == 2">
                            <b-link :href="`create_total_group_score_pdf/${group.group_code}?region=${group.region_id}&start=${startZvitDate}&end=${endZvitDate}`"
                                    size="sm"
                                    class="btn btn-primary"
                                    target="_blank"
                                    :disabled="!startZvitDate || !endZvitDate">Звіт контори
                            </b-link>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="12" lg="2" xl="4" align="center" class="mt-md-5">
                    <b-button
                            type="button"
                            size="lg"
                            variant="primary"
                            @click="handlerClick">
                        Калькулятор
                    </b-button>
                </b-col>
            </b-row>
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
            role: {
                type: Number,
                default() {
                    return 0
                }
            },
            group: {
                type: String,Number,
                default() {
                    return '00'
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
                        text: 'Оберіть місяць'
                    },
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
                periodsZvit: [
                    {
                        value: null,
                        text: 'Оберіть місяць'
                    },
                    {
                        value: 12,
                        text: 'За рік'
                    },
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
                startZvitDate: null,
                endZvitDate: null,
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
                selectedPeriod: null,
                selectedPeriodZvit: null
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
                let countDays = moment().month(id).daysInMonth()
                this.startDate = moment().month(id).format('YYYY-MM-01');
                this.endDate = `${moment().month(id).format('YYYY-MM')}-${countDays}`;
            },
            filterZvitPeriod(id) {
                if(id == 12) {
                    this.startZvitDate = moment().format('YYYY-01-01');
                    this.endZvitDate = moment().format('YYYY-12-31');
                } else {
                    let countDays = moment().month(id).daysInMonth()
                    this.startZvitDate = moment().month(id).format('YYYY-MM-01');
                    this.endZvitDate = `${moment().month(id).format('YYYY-MM')}-${countDays}`;
                }

            }
        }
    }
</script>