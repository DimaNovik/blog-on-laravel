<template>
    <b-row>
        <b-col>
            <b-table striped
                     hover
                     responsive
                     :items="data"
                     :fields="fields"
                     :filter="getFilterText"
                     :current-page="currentPage"
                     :per-page="perPage">
                <template v-slot:cell(type)="row">
                    <span v-if="row.item.type != 1">Сплачено</span>
                    <b-button size="sm"
                              variant="warning"
                              v-else>
                        Редагувати
                    </b-button>
                </template>
            </b-table>

            <p v-if="!data.length">Дані відстуні</p>

            <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    size="sm"
                    v-if="data.length"
            ></b-pagination>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "ServicesTable",
        props: {
            filter: {
                type: String,
                default() {
                    return ''
                }
            },
            data: {
                type: Array, Object,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                fields: [
                    {
                        key: "code",
                        label: "Код дії",
                        sortable: true
                    },
                    {
                        key: "count",
                        label: "Кідькість",
                        sortable: true
                    },
                    {
                        key: "price",
                        label: "Вартість",
                        sortable: true
                    },
                    {
                        key: "start_date",
                        label: "Дата створення",
                        sortable: true
                    },
                    {
                        key: "finish_date",
                        label: "Дата оплати",
                        sortable: true
                    },
                    {
                        key: "type",
                        label: "Статус",
                        sortable: true
                    },

                ]
            }
        },
        computed: {
          getFilterText() {
              return this.filter
          }
        },
        mounted() {
            this.totalRows = this.data.length
        },
    }
</script>