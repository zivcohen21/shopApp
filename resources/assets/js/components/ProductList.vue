<template>
    <div class='row'>
        <h1>Our Products</h1>
        <ul class="list-group">
            <li v-if='list.length === 0'>No Available Products!</li>
            <li v-if='product.amount !== 0' class="list-group-item" v-for="(product, index) in list">
                {{ product.title }}
                {{ product.price }}
                {{ product.img }}
                Amount: {{ product.amount }}
                <label for="quantity"></label>
                <input type="number" id="quantity" min="1" v-model="amountToBuy[product.id]">
               <!-- <p v-if='message && message[index]'>{{ message[index] }}</p>-->
                <button @click="addToCart(product, index)" class="btn btn-danger btn-xs pull-right">Add To Cart</button>
            </li>
        </ul>
    </div>
</template>

<script>

    import axios from 'axios';
    import MyCart from './MyCart';
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
                cartData: {
                    productId: '',
                    amountToBuy: 0
                },
                amountToBuy: [],
                message: [],
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
            addToCart(product, index) {
                this.cartData.productId = product.id;
                this.cartData.amountToBuy = parseInt(this.amountToBuy[product.id]);
                console.log(this.cartData);
                if(this.cartData.amountToBuy <= this.list[index].amount)
                {
                    axios.post('api/products', this.cartData).then((res) => {
                        if(res && res['data']['product'])
                        {
                            this.list[index].amount = res['data']['product'][0]['amount'];
                        }
                        else {
                            this.list[index].amount = 0;
                        }
                    });
                    this.amountToBuy[product.id] = '';
                }
                else {
                    this.message[index] = 'Not Enough In Stock';
                    console.log(this.message[index]);
                }

            }
        }
    }
</script>

<style scoped>

</style>