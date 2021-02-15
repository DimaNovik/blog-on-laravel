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
    import InvoicePopup from '../popups/SavePayment';
    import MorePopup from '../popups/MoreInfo';
    import { mapActions, mapGetters, mapMutations } from 'vuex';

    export default {
        name: "ServicesAllTable",
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
                        key: "region_id",
                        label: "Код регіону",
                        sortable: true
                    },
                    {
                        key: "office_id",
                        label: "Код контори",
                        sortable: true
                    },
                    {
                        key: "name",
                        label: "Нотаріус",
                        sortable: true
                    },
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
                        label: "Кількість",
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
                        key: "action_date",
                        label: "Дата над.пос.",
                        sortable: true
                    },
                    {
                        key: "pay_date",
                        label: "Дата оплати",
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
                if(this.isOpenMore) return;
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