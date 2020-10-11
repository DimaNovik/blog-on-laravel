<template>
    <div class="page page--settings">
        <div class="settings">
            <b-container>
                <b-row class="mt-5">
                    <b-col>
                        <router-link to="/pages/calculator/main">
                            До калькулятора
                        </router-link>
                    </b-col>
                    <b-col align="center">
                        <h4>Налаштування даних калькулятора</h4>
                    </b-col>
                </b-row>
                <b-row class="mt-3">
                    <b-col>
                        <b-card no-body>
                            <b-tabs v-model="tabIndex" card >
                                <b-tab title="Ціни" :title-link-class="linkClass(0)">
                                    <p>Коригування вартості послуг</p>
                                    <SettingPrice class="mt-5 mb-5"/>
                                </b-tab>
                                <b-tab title="Користувачі" :title-link-class="linkClass(1)">
                                    <p>Управління користувачами</p>
                                    <SettingUser class="mt-5 mb-5"/>
                                </b-tab>
                                <b-tab title="Додати користувача" :title-link-class="linkClass(2)">
                                    <p>Додати нового користувача</p>
                                    <SettingNewUser class="mt-5 mb-5"/>
                                </b-tab>
                                <b-tab title="Статистика" :title-link-class="linkClass(3)">
                                    <p>Реєстр</p>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>

    import SettingPrice from '@/components/common/SettingPrice';
    import SettingUser from '@/components/common/SettingUser';
    import SettingNewUser from '@/components/common/SettingNewUser';

    export default {
        name: "Settings",
        data() {
            return {
                tabIndex: 0
            }
        },
        components: {
            SettingPrice,
            SettingUser,
            SettingNewUser
        },
        methods: {
            linkClass(idx) {
                if (this.tabIndex === idx) {
                    return ['bg-primary', 'text-light']
                } else {
                    return ['bg-light', 'text-info']
                }
            }
        }
    }
</script>