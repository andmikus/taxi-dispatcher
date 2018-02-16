
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

/**
 *  Load Datatables library
 */
require('datatables.net-bs4');
require('datatables.net-responsive-bs4');

$.extend($.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    paging: true,
    searching: true,
    info: true,
    autoWidth: false,
    responsive: true,
    searchDelay: 350
});
