/**
 * Created by lesin on 17/12/14.
 */
import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from './components/Example.vue'
import Login from './components/Login.vue'
import Home from './components/Home.vue'
import Admin from './components/Admin.vue'
import Manage from './components/Manage.vue'
import Export from './components/Export.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/',
            name: 'Home',
            component: Home,
            children: [{
                path: 'admin',
                component: Admin
            }, {
                path: 'export',
                component: Export
            }, {
                path: 'manage',
                component: Manage
            }]
        }
    ]
})