import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from '../views/Auth.vue'
import Main from '../views/ServicesList.vue'
import Create from '../views/ServicesCreate.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/pages/calculator',
        name: 'Auth',
        component: Auth
    },
    {
        path: '/pages/calculator/main',
        name: 'Main',
        component: Main
    },
    {
        path: '/pages/calculator/create',
        name: 'Create',
        component: Create
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
