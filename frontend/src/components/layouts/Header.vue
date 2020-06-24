<template>
    <header class="header">
        <b-container>
            <b-row align-v="center">
                <b-col md="10">
                    <div class="header__logo">
                        <img src="https://notary-just.odessa.gov.ua/images/main-logo.png" alt="">
                    </div>
                </b-col>
                <b-col md="2" align="center">
                    <b-link
                        :href="'/'"
                        class="header__link">
                        На головний сайт
                    </b-link>
                </b-col>
            </b-row>
        </b-container>
    </header>
</template>

<script>
    export default {
        name: "Header"
    }
</script>