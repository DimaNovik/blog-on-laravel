<template>
    <b-row align-v="center">
        <b-col md="9" xl="10" >
            <p><b>Загальна кількість:</b> {{count}} </p>
            <p>
                <a href="#">

                    <download-excel
                            :data  = "item"
                            :fields = "json_fields"
                            name    = "filename.xls">

                        Завантажити дані у Excel
                        <img src="https://img.icons8.com/officexs/16/000000/ms-excel.png" class="mt-n1 ml-2"/>
                    </download-excel></a></p>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "ServicesAdminTotal",
        props: {
            item: {
                type: Array,Object,
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
        },
        data() {
            return {
                json_fields: {
                    'Код регіону': 'region_id',
                    'Код офісу': 'office_id',
                    'Нотаріус': 'name',
                    'Код дії': 'code',
                    'Загальна кількість': 'count',
                    'Вартість': 'price',
                    'Дата створення': 'created_at',
                    'Дата сплати': 'pay_date',
                    'ПІБ': 'fio',
                },
            }
        },
    }
</script>