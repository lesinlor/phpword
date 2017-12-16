
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

<<<<<<< HEAD
window.Vue = require('vue');

=======
>>>>>>> 6e0e8259bbaf1b197e2f92cfdab0a75cb5254a9c
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

<<<<<<< HEAD
Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
=======
import App from './App.vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import router from './router';

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
>>>>>>> 6e0e8259bbaf1b197e2f92cfdab0a75cb5254a9c
});
