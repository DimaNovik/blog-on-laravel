<template>
    <b-row align-v="center">
        <b-col md="9" xl="10" >
            <p><b>Загальна кількість:</b> {{count}} </p>
            <p><a href="#" class="primary">Завантажити дані у Excel</a></p>
        </b-col>
        <b-col md="3" xl="2" align="right">
            <b-button
                type="button"
                variant="primary"
                @click="handlerClick">
                Створити договір
            </b-button>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        name: "ServicesTotal",
        props: {
            count: {
                type: Number, String,
                default() {
                    return 0
                }
            }
        },
        methods: {
            handlerClick() {
                this.$router.push('/pages/calculator/create');
            }
        }
    }
</script>