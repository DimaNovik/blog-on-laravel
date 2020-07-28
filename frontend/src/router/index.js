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
        // beforeEnter: (to, from, next) =>
        // {
        //     store.dispatch('User/checkUser').then(response => {
        //         next();
        //         // the above state is not available here, since it
        //         // it is resolved asynchronously in the store action
        //     }, error => {
        //         // handle error here
        //         next('/pages/calculator')
        //     })
        // }
    },
    {
        path: '/pages/calculator/main',
        name: 'Main',
        component: Main,
        beforeEnter: (to, from, next) =>
        {
            store.dispatch('User/checkUser').then(response => {
                store.dispatch('User/userGroup', response.group_id).then(()=> {
                    next();
                })
            }, error => {
                next('/pages/calculator')
            })
        }
    },
    {
        path: '/pages/calculator/create',
        name: 'Create',
        component: Create
    },
    {
        path: '/pages/calculator/settings',
        name: 'Settings',
        component: Settings
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
