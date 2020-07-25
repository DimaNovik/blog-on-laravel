import Vue from 'vue'
import App from './App.vue'
import router from './router'
import {store} from './store';
import { BootstrapVue} from 'bootstrap-vue';
import 'jspdf'

Vue.config.productionTip = false;


// Install BootstrapVue
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/app.scss';

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
