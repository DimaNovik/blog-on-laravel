<template>
    <b-row>
        <b-col md="8">
            <p v-if="info.role == 0 || info.role == 2"><b>Відділ:</b> {{group}}</p>
            <p v-if="info.role == 0 || info.role == 2"><b>Нотаріус:</b> {{info.name}}</p>
        </b-col>
        <b-col md="4" align="right">
            <p><b>Дата:</b> {{getDatetimeInfo}}</p>
            <p v-if="info.role == 1">
                <router-link
                        class="primary d-inline-flex"
                        to="/pages/calculator/settings">
                    Налаштування даних
                    <span class="close d-flex align-baseline ml-2">
                    <img src="https://img.icons8.com/windows/32/000000/settings.png"/>
                </span>
                </router-link>
            </p>
            <p>
                <a href="#"
                   @click.prevent="userLogout"
                   class="primary d-inline-flex">
                    Вийти
                    <span class="close d-flex align-baseline ml-2">
                        <img src="https://img.icons8.com/small/16/000000/exit.png"/>
                    </span>
                </a>
            </p>
        </b-col>
    </b-row>
</template>

<script>

    import { mapActions } from 'vuex';

    export default {
        name: "ServicesTopInfo",
        props: {
            info: {
                type: Object,
                default() {
                    return {}
                }
            },
            group: {
                type: String,
                default() {
                    return ''
                }
            }
        },
        computed: {
            getDatetimeInfo() {
                let date = new Date();
                let monthName = ['Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня'];

                return date.getDate() + ' ' + monthName[date.getMonth()] + ', ' + date.getFullYear();
            }
        },
        methods: {
            ...mapActions('User', ['logout']),
            userLogout() {
                this.logout().then(()=> {
                    this.$router.push('/pages/calculator')
                });
            }
        }
    }
</script>