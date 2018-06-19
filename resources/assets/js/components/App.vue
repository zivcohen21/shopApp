<template>
    <div>
        <p>
            <router-link :to="{ name: 'productList' }">Home</router-link> |
            <router-link :to="{ name: 'myCart' }">My Cart</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>