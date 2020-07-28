<template>
    <header class="header">
        <b-container>
            <b-row align-v="center">
                <b-col md="8" xl="10" sm="6">
                    <div class="header__logo">
                        <img src="https://notary-just.odessa.gov.ua/images/main-logo.png" alt="">
                    </div>
                </b-col>
                <b-col md="4" xl="2" sm="6" align="right">
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