
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import router from './router';

Vue.use(ElementUI);

router.beforeEach((to, from, next) => {
    if(to.path == '/login'){
        next()
        return
    }
    axios.get("/api/session").then((res)=>{
        if(res.data.code === 0) {
            let user = res.data.data
            // admin必须是管理员
            if( to.path == '/admin' && (user.role_id == 1 || user.role_id == 2) )next()
            // 除admin
            if( to.path != '/admin' ) next()
        }else{
            next({ path: '/login' })
        }
    }).catch(err => {
        if(to.path == '/login'){
            next()
        }
        next('/login')
    })
})

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
