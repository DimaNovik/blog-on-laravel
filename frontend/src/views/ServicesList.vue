<template>
    <div class="page page--services">
        <b-container>
            <div class="services">
                <ServicesTopInfo
                    :info="getUserInfo"
                    :group="getGroupName"></ServicesTopInfo>

                <hr/>

                <div class="services__info">
                    <ServicesTotal
                        :item="ordersData"
                        :count="ordersData.length"
                        :role="getUserRole"
                        v-if="getUserRole != 1" />

                    <ServicesAdminTotal
                            :item="allOrders"
                            :count="allOrders.length"
                            v-else />
                </div>

                <ServicesFilter
                    @filter="getFilterText"></ServicesFilter>

                <div class="services__table" v-if="getUserRole != 1">
                    <ServicesTable
                        :value="ordersData"
                        :filter="filterText"
                        @update="getUpdatedOrders"></ServicesTable>
                </div>

                <div class="services__table" v-else>
                    <ServicesAllTable
                            :value="allOrders"
                            :filter="filterText"
                            @update="getUpdatedOrders"
                    />
                </div>
            </div>
        </b-container>
    </div>
</template>

<script>

    import ServicesTopInfo from "@/components/common/ServicesTopInfo";
    import ServicesTotal from "@/components/common/ServicesTotal";
    import ServicesAdminTotal from "@/components/common/ServicesAdminTotal";
    import ServicesFilter from "@/components/common/ServicesFilter";
    import ServicesTable from "@/components/common/ServicesTable";
    import ServicesAllTable from "@/components/common/ServicesAllTable";

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
            ServicesTable,
            ServicesAllTable,
            ServicesAdminTotal
        },
        computed: {
            ...mapGetters('Orders', ['orders', 'allOrders']),
            ...mapGetters('User', ['user', 'userGroup']),
            ordersData() {
                return this.orders || [];
            },
            getUserInfo() {
                return this.user || {}
            },
            getUserId() {
                return this.user && this.user.id
            },
            getGroupName() {
                return this.userGroup && this.userGroup.name || ''
            },
            getUserRole() {
                return this.user && this.user.role
            }
        },
        methods: {
            ...mapActions('Orders', ['getOrders', 'getAllOrders', 'getAllUsers']),
            getFilterText(val) {
                this.filterText = val
            },
            getUpdatedOrders() {
                this.getOrders(this.getUserId);
            }
        },
    }
</script>