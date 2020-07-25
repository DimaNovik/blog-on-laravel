<template>
    <b-row>
        <b-col>
            <b-table striped
                     hover
                     responsive
                     :items="value"
                     :fields="fields"
                     :filter="getFilterText"
                     :current-page="currentPage"
                     :per-page="perPage"
                     @row-clicked="showDetails">
                <template v-slot:cell(type)="row" >
                    <span v-if="row.item.type == 1" class="success"><b>Сплачено</b></span>
                    <span v-else>

                        <b-button size="sm"
                                  variant="warning"
                                  type="button"
                                  @click="openInvoice(
                                      {id : row.item.id,
                                      create: row.item.created_at,
                                      code: row.item.code || '',
                                      fio: row.item.fio,
                                      })">
                                Занести оплату
                            </b-button>

                    </span>
                    <b-link :href="`pdf-create/${row.item.id}`"
                            size="sm"
                            class="ml-3"
                            variant="success"
                            target="_blank">Квітанція
                    </b-link>
                </template>
            </b-table>

            <p v-if="!value.length">Дані відстуні</p>

            <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    size="sm"
                    v-if="value.length"
            ></b-pagination>

            <InvoicePopup
                :isActive="isOpenSavePayment"
                :item="rowPaymentData"
                @showPopup="successPayment"/>

            <MorePopup
                    :isActive="isOpenMore"
                    :item="getMoreInfo"
                    @showPopup="closeMore"/>
        </b-col>
    </b-row>
</template>

<script>
    import InvoicePopup from './SavePayment';
    import MorePopup from './MoreInfo';
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        name: "ServicesTable",
        props: {
            filter: {
                type: String,
                default() {
                    return ''
                }
            },
            value: {
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
                        key: "fio",
                        label: "ПІБ платника",
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
                        key: "created_at",
                        label: "Дата створення",
                        sortable: true
                    },
                    {
                        key: "pay_date",
                        label: "Дата оплати",
                        sortable: true
                    },
                    {
                        key: "type",
                        label: "Статус",
                        sortable: true
                    },

                ],
                isOpenSavePayment: false,
                rowPaymentData: null,
                isShowDetails: false,
                isOpenMore: false
            }
        },
        components: {
            InvoicePopup,
            MorePopup
        },
        computed: {
            ...mapGetters('Calculator', ['moreInfo']),
            getFilterText() {
                return this.filter
            },
            getMoreInfo() {
                return this.moreInfo || {}
            }
        },
        methods: {
            ...mapActions('Calculator', ['getOnceAction', 'getOnceService']),
            ...mapMutations('Calculator', ['clearMoreInfo']),
            getPDF(id) {
                this.$router.push(`pages/calculator/pdg-create/${id}`)
            },
            openInvoice(data) {
                this.isOpenSavePayment = true;
                this.rowPaymentData = data;
            },
            successPayment() {
                this.isOpenSavePayment = false;
                this.$emit('update');
            },
            showDetails(record, index) {
                let services = JSON.parse(record.service_id);

                this.getOnceAction(record.action_id).then(()=> {
                    this.isOpenMore = true;

                   services.forEach(item => {
                        this.getOnceService({id: item.service, count: item.count})
                    })

                })
            },
            closeMore() {
                this.isOpenMore = false;
                this.clearMoreInfo();
            },
        },
        created() {
            this.totalRows = this.value.length
        },
    }
</script>