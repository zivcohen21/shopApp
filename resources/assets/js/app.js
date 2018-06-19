import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './components/App'
import ProductList from './components/ProductList'
import MyCart from './components/MyCart'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'productList',
            component: ProductList
        },
        {
            path: '/mycart',
            name: 'myCart',
            component: MyCart,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});