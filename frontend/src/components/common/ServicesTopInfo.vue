<template>
    <b-row>
        <b-col md="9">
            <p><b>Відділ:</b> Приморська державна нотаріальна контора у м. Одеса</p>
            <p><b>Нотаріус:</b> Пенчев Костянтин Леонтійович</p>
        </b-col>
        <b-col md="3" align="right">
            <p><b>Дата:</b> {{getDatetimeInfo}}</p>
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