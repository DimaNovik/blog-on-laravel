import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from '../views/Auth.vue'
import Main from '../views/ServicesList.vue'
import Create from '../views/ServicesCreate.vue'
import Settings from '../views/Settings.vue'

import { store } from '@/store';

Vue.use(VueRouter)

const routes = [
    {
        path: '/pages/calculator',
        name: 'Auth',
        component: Auth,
    },
    {
        path: '/pages/calculator/main',
        name: 'Main',
        component: Main,
        beforeEnter: (to, from, next) =>
        {
            store.dispatch('User/checkUser').then(response => {
                store.dispatch('User/userGroup', response.group_id).then(()=> {

                    if(response.role == 0) {
                        let id = (response.id<10) ? `0${response.id}`: response.id
                        store.dispatch('Orders/getOrders', id).then(()=> {
                            next();
                        })
                    } else {

                        store.dispatch('Orders/getAllOrders').then(()=> {
                            store.dispatch('Orders/getAllUsers').then(()=> {
                                next();
                            })
                        })
                    }

                })
            }, error => {
                next('/pages/calculator')
            })
        }
    },
    {
        path: '/pages/calculator/create',
        name: 'Create',
        component: Create,
        beforeEnter: (to, from, next) =>
        {
            store.dispatch('Calculator/getAllPrice').then(response => {
                next();
            }, error => {
                next('/pages/calculator')
            })
        }
    },
    {
        path: '/pages/calculator/settings',
        name: 'Settings',
        component: Settings
    },
    {
        path: '*',
        redirect: '/pages/calculator/main'
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
