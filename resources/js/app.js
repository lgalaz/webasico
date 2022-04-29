/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import store from './store';

/**
 * We set this header so that we can pass the user to vuex in app.js
 */

let userHeader = document.head.querySelector('meta[name="user"]');

if (userHeader && userHeader.content) {
    store.commit('setUser',  JSON.parse(userHeader.content));
    userHeader.remove();
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('nav-bar', require('./components/NavBar.vue').default);
Vue.component('wb-alert', require('./components/WbAlert.vue').default);
Vue.component('website-index', require('./components/website/Index.vue').default);
Vue.component('website-configure', require('./components/website/Configure.vue').default);
Vue.component('website', require('./components/website/Show.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
