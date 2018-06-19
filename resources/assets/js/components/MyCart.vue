<template>
    <div class='row'>
        <h1>My Cart</h1>
        <ul class="list-group">
            <li v-if='cartList.length === 0'>Empty Cart</li>
            <li v-if='product.amount !== 0' class="list-group-item" v-for="(product, index) in cartList">
                {{ product.title }}
                {{ product.price }}
                {{ product.img }}
                Amount: {{ product.amount }}
                <label for="quantity"></label>
                <input type="number" id="quantity" min="1" v-model="amountToBuy[product.id]">
                <!-- <p v-if='message && message[index]'>{{ message[index] }}</p>-->
<!--
                <button @click="addToCart(product, index)" class="btn btn-danger btn-xs pull-right">Add To Cart</button>
-->
            </li>
        </ul>
    </div>
</template>

<script>

    import axios from 'axios';
    export default {
        data() {
            return {
                list: [],
                product: {
                    id: '',
                    title: '',
                    price: '',
                    img: '',
                    amount: 0
                },
                amountToBuy: [],
                message: [],
                cartList: []
            };
        },

        created() {
            this.fetchCartList();
        },


        methods: {
            fetchCartList() {
                axios.get('api/mycart').then((res) => {
                    console.log(res);
                });
            },
        }
    }
</script>

<style scoped>

</style>