<template>
    <div class="page page--services">
        <b-container>
            <div class="services">
                <ServicesTopInfo></ServicesTopInfo>

                <hr/>

                <div class="services__info">
                    <ServicesTotal
                        :count="ordersData.length"></ServicesTotal>
                </div>

                <ServicesFilter
                    @filter="getFilterText"></ServicesFilter>

                <div class="services__table">
                    <ServicesTable
                        :value="ordersData"
                        :filter="filterText"
                        @update="getUpdatedOrders"></ServicesTable>
                </div>
            </div>
        </b-container>
    </div>
</template>

<script>

    import ServicesTopInfo from "@/components/common/ServicesTopInfo";
    import ServicesTotal from "@/components/common/ServicesTotal";
    import ServicesFilter from "@/components/common/ServicesFilter";
    import ServicesTable from "@/components/common/ServicesTable";

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "ServicesList",
        data() {
            return {
                filterText: ''
            }
        },
        components: {
            ServicesTopInfo,
            ServicesTotal,
            ServicesFilter,
            ServicesTable
        },
        computed: {
            ...mapGetters('Orders', ['orders']),
            ordersData() {
                return this.orders || [];
            },
        },
        methods: {
            ...mapActions('Orders', ['getOrders']),
            getFilterText(val) {
                this.filterText = val
            },
            getUpdatedOrders() {
                this.getOrders('01');
            }
        },
        created() {
            this.getOrders('01');
        }
    }
</script>