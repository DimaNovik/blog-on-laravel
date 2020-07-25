<template>
    <b-row>
        <b-col md="8">
            <p><b>Відділ:</b> Приморська державна нотаріальна контора у м. Одеса</p>
            <p><b>Нотаріус:</b> Пенчев Костянтин Леонтійович</p>
        </b-col>
        <b-col md="4" align="right">
            <p><b>Дата:</b> {{getDatetimeInfo}}</p>
            <p class="flex">
                <router-link
                class="success"
                to="/">
                Налаштування даних
                <span class="close">
                    <img src="https://img.icons8.com/windows/32/000000/settings.png"/>
                </span>
            </router-link></p>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "ServicesTopInfo",
        computed: {
            getDatetimeInfo() {
                let date = new Date();
                let monthName = ['Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня'];

                return date.getDate() + ' ' + monthName[date.getMonth()] + ', ' + date.getFullYear();
            }
        }
    }
</script>