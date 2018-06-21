<template>
    <div>
        <p>
            <router-link :to="{ name: 'productList' }">Home</router-link> |
            <router-link :to="{ name: 'myCart' }">My Cart ({{ numberOfItems }})</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        data()
        {
            return {
                numberOfItems: 0
            };
        },
        created() {
            this.fetchCartNum();
        },
        methods: {
            fetchCartNum() {
                this.numberOfItems = localStorage.getItem('numberOfItems');
            },
        }
    }
</script>