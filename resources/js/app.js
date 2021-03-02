/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import swal from 'sweetalert2';
window.Swal = swal;
import VueRouter from 'vue-router';


require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform'


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar,{
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/buses', component: require('./components/ManageBus.vue').default },
    { path: '/manage_driver', component: require('./components/ManageDriver.vue').default },
    { path: '/transaction', component: require('./components/Transaction.vue').default },
    { path: '/topup', component: require('./components/TopUp.vue').default }

  ]

const router = new VueRouter({
  mode: 'history',
    routes // short for `routes: routes`
  })

  Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
  });

window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import ExampleComponent from './components/ExampleComponent.vue';
import { values } from 'lodash';

Vue.component(
  'example-component',
  require('./components/ExampleComponent.vue').default);/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
