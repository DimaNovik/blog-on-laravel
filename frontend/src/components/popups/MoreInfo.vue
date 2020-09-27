<template>
    <div class="invoice invoice--more"
         :class="{'active': isActive}">
        <b-row class="mb-4">
            <b-col></b-col>
            <b-col>
                <a href="#"
                   class="close"
                   @click="hide">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 26.7 26.6" style="enable-background:new 0 0 26.7 26.6;" xml:space="preserve">
    <polygon class="st0" stroke="#000000" stroke-width="0.75" stroke-miterlimit="10" points="26.1,2 24.7,0.5 13.3,11.8 2,0.5 0.5,2 11.9,13.3 0.5,24.6 2,26.1 13.3,14.8 24.7,26.1 26.1,24.6
        14.8,13.3 "/>
    </svg>
                </a>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                <p><b>{{item.name}}</b></p>
                <hr />
            </b-col>
        </b-row>


        <b-row>
            <b-col cols="10">
                <p><b>Надана дія:</b></p>
            </b-col>
            <b-col cols="2">
                <p><b>Кількість</b></p>
            </b-col>
        </b-row>

        <b-row v-for="(val, i) in item.list"
            :key="i">
            <b-col cols="10">
                <p>{{val.name}}</p>
            </b-col>
            <b-col cols="2">
                <p>{{val.count}}</p>
            </b-col>
        </b-row>

    </div>
</template>

<script>
    export default {
        name: "MoreInfo",
        props: {
            item: {
                type: Object,
                default() {
                    return {}
                },
            },
            isActive: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            hide() {
                this.$emit('showPopup');
            }
        }
    }
</script>