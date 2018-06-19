<template>
    <div class='row'>
        <h1>Our Products</h1>
        <ul class="list-group">
            <li v-if='list.length === 0'>No Available Products!</li>
            <li class="list-group-item" v-for="(product, index) in list">
                {{ product.title }}
                {{ product.price }}
                {{ product.img }}
                Amount: {{ product.amount }}
                <label for="quantity"></label>
                <input type="number" id="quantity" min="1" v-model="amountToBuy[product.id]">
                <button @click="addToCart(product.id, index)" class="btn btn-danger btn-xs pull-right">Add To Cart</button>
            </li>
        </ul>

        <router-link :to="{ name: 'myCart' }">My Cart</router-link>
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
                    amount: ''
                },
                cartData: {
                    productId: '',
                    amountToBuy: 0
                },
                amountToBuy: [],
            };
        },

        created() {
            this.fetchProductList();
        },

        methods: {
            fetchProductList() {
                axios.get('api/products').then((res) => {
                    this.list = res.data.product;
                    console.log( this.list);
                });
            },
            addToCart(productId, index) {
                this.cartData.productId = productId;
                this.cartData.amountToBuy = parseInt(this.amountToBuy[productId]);
                console.log(this.cartData);
                if(this.cartData.amountToBuy <= this.list[index].amount)
                {
                    axios.post('api/products', this.cartData).then((res) => {
                        if(res && res['data']['product'])
                        {
                            console.log(res['data']['product']);
                            this.list[index].amount = res['data']['product'][0]['amount'];
                        }
                        else if(res['data']['product'] == null)
                        {
                            this.list[index] = null;
                            console.log(this.list[index]);
                        }
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>