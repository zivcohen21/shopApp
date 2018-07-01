<template>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/mycart"><i class="fas fa-shopping-cart fa"></i>({{numberOfItems}})</a></li>
            </ol>
        </nav>
        <div>
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import { EventBus } from '../event-bus.js';
    export default {
        data()
        {
            return {
                numberOfItems: 0
            };
        },

        created() {
            this.fetchCartList();
        },


        methods: {
            fetchCartList() {
                axios.get('api/mycart').then((res) => {
                    //this.cartList = res.data.item;
                    this.numberOfItems = res.data.item.length;
                });
            },
        },

        mounted()
        {
            EventBus.$on('numberOfItems', num => {
                if(num === 1)
                {
                    this.numberOfItems++;
                }
                else if(num === 0 && this.numberOfItems > 0)
                {
                    this.numberOfItems--;
                }

            });
        }
    }

</script>