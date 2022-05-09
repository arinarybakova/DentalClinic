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

import Vuetify from 'vuetify'
import DaySpanVuetify from 'dayspan-vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'dayspan-vuetify/dist/lib/dayspan-vuetify.min.css'

Vue.use(Vuetify);

Vue.use(DaySpanVuetify, {
  methods: {
    getDefaultEventColor: () => '#2fbab8'
  }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Admin procedures
Vue.component('procedure-table', require('./components/admin/procedure/Table.vue').default);
Vue.component('procedure-form', require('./components/admin/procedure/Form.vue').default);
Vue.component('add-procedure', require('./components/admin/procedure/Create.vue').default);
Vue.component('edit-procedure', require('./components/admin/procedure/Edit.vue').default);
Vue.component('delete-procedure', require('./components/admin/procedure/Delete.vue').default);

//Admin users
Vue.component('users', require('./components/admin/users/Table.vue').default);
Vue.component('user-form', require('./components/admin/users/Form.vue').default);
Vue.component('add-user', require('./components/admin/users/Create.vue').default);
Vue.component('edit-user', require('./components/admin/users/Edit.vue').default);
Vue.component('delete-user', require('./components/admin/users/Delete.vue').default);
Vue.component('treatment-admin-modal', require('./components/admin/treatment/AdminModal.vue').default);
Vue.component('treatment-dentist-modal', require('./components/admin/treatment/DentistModal.vue').default);
Vue.component('approve-treatment', require('./components/admin/treatment/Approve.vue').default);
Vue.component('cancel-treatment', require('./components/admin/treatment/Cancel.vue').default);

//Admin scheduler
Vue.component('schedule', require('./components/admin/scheduler/Index.vue').default);
Vue.component('calendar', require('./components/admin/scheduler/Calendar.vue').default);
Vue.component('edit-event', require('./components/admin/scheduler/Edit.vue').default);
Vue.component('info-event', require('./components/admin/scheduler/EventInfo.vue').default);
Vue.component('event-form', require('./components/admin/scheduler/EventForm.vue').default);

Vue.component('form-error', require('./components/ui/FormError.vue').default);
Vue.component('toast', require('./components/ui/Toast.vue').default);

//Admin appointments
Vue.component('appointment', require('./components/admin/appointment/Table.vue').default);
Vue.component('approve-appointment', require('./components/admin/appointment/Approve.vue').default);
Vue.component('cancel-appointment', require('./components/admin/appointment/Cancel.vue').default);

//Admin profile
Vue.component('profile', require('./components/admin/profile.vue').default);

//Frontend procedures
Vue.component('procedures', require('./components/frontend/procedures.vue').default);

//Frontend appointments
Vue.component('appointments', require('./components/frontend/appointments.vue').default);

//Frontend treatments
Vue.component('treatments', require('./components/frontend/treatments.vue').default);

//Frontend profile
Vue.component('profile', require('./components/frontend/profile/Index.vue').default);
Vue.component('profile-form', require('./components/frontend/profile/Form.vue').default);

Vue.component('reservation-modal', require('./components/frontend/reservation/reservation.vue').default);
Vue.component('reservation-day', require('./components/frontend/reservation/reservationDay.vue').default);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('component', require('./components/Home.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
});