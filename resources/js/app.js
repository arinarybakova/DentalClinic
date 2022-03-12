/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import vue from 'vue'
window.Vue = vue;

// imports
import VueAxios from 'vue-axios';
import axios from 'axios';

import Vue from 'vue'
import { BootstrapVue } from 'bootstrap-vue'

import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)

Vue.use(VueAxios, axios);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('procedure-table', require('./components/admin/procedure/Table.vue').default);
Vue.component('procedure-form', require('./components/admin/procedure/Form.vue').default);
Vue.component('add-procedure', require('./components/admin/procedure/Create.vue').default);

Vue.component('form-error', require('./components/ui/FormError.vue').default);
Vue.component('toast', require('./components/ui/Toast.vue').default);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('component', require('./components/Home.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});