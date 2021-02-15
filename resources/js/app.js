/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import App from './views/App.vue';
import Home from './components/Home.vue';
import Clientes from './views/Clientes.vue';
import Vehiculos from './views/Vehiculos.vue';
import UsersIndex from './views/UsersIndex';
import UsersCreate from './views/UsersCreate';
import UsersEdit from './views/UsersEdit';
import NotFound from './views/NotFound';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/clientes',
            name: 'clientes',
            component: Clientes,
        },
        {
            path: '/vehiculos',
            name: 'vehiculos',
            component: Vehiculos,
        },
        // {
        //     path: '/users',
        //     name: 'users.index',
        //     component: UsersIndex,
        // },
        // {
        //     path: '/users/create',
        //     name: 'users.create',
        //     component: UsersCreate,
        // },
        // {
        //     path: '/users/:id/edit',
        //     name: 'users.edit',
        //     component: UsersEdit,
        // },
        { path: '/404', name: '404', component: NotFound },
        { path: '*', redirect: '/404' },
    ],
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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
