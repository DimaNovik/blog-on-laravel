import Vue from 'vue'
import App from './App.vue'
import router from './router'
import {store} from './store';
import { BootstrapVue} from 'bootstrap-vue';
import JsonExcel from 'vue-json-excel'
import VueLodash from 'vue-lodash'
import lodash from 'lodash'

Vue.config.productionTip = false;
Vue.use(VueLodash, { name: 'custom' , lodash: lodash })


// Install BootstrapVue
Vue.use(BootstrapVue);
Vue.component('downloadExcel', JsonExcel)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/app.scss';

import Cookies from 'js-cookie';

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
