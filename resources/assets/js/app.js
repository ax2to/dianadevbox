/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('panel', require('./components/Panel.vue'));
Vue.component('pipeline', require('./components/tickets/Pipeline.vue'));
Vue.component('create', require('./components/tickets/Create.vue'));
Vue.component('datagrid', require('./components/tickets/Datagrid.vue'));
Vue.component('datagrid-row', require('./components/tickets/DatagridRow.vue'));
Vue.component('contact', require('./components/tickets/Contact.vue'));
Vue.component('ticket', require('./components/tickets/Ticket.vue'));
Vue.component('comments', require('./components/tickets/Comments.vue'));

const app = new Vue({
    el: '#app'
});
