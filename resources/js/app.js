/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.axios = require('axios');
window.req = axios.create({
    baseURL: '/'
})

import router from './router'
import common from './common'
import Vue from 'vue';



Vue.mixin(common)

//Login

Vue.component('login-component', require('./components/adminLogin/AdminLogin.vue').default);
Vue.component('login-inputs', require('./components/adminLogin/loginInput.vue').default);
Vue.component('app-page', require('./components/adminLogin/App.vue').default);

Vue.component('input-page', require('./components/Input.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('viewCategory', require('./components/category/ViewCategory.vue').default);
Vue.component('add-product', require('./components/product/AddProduct.vue').default);
Vue.component('view-service', require('./components/service/ViewService.vue').default);

const app = new Vue({
    el: '#app',
    router
});
