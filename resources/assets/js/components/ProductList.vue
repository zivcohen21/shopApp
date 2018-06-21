<template>
    <div class='row'>
        <h1>Our Products</h1>
        <p v-if='list.length === 0'>No Available Products!</p>
        <table class="table" v-if='list.length !== 0'>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Amount In Stock</th>
                <th>Amount To Buy</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-if='product.amount !== 0' v-for="(product, index) in list">
                <td>{{ product.title }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.amount }}</td>
                <td> <input class="amount" type="number" id="quantity" min="1" v-model="amountToBuy[product.id]"></td>
                <td> <button @click="addToCart(product, index)" class="btn btn-outline-success btn-xs pull-right">Add To Cart</button></td>
                <td>{{ message[index] }}</td>
            </tr>
        </table>

    </div>
</template>

<script>

    import axios from 'axios';
    import { EventBus } from '../event-bus';
    export default {
        data() {
            return {
                list: [],
                tempList: [],
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
                numberOfItems: 0,
            };
        },

        created() {
            this.fetchProductList();
        },

        methods: {
            fetchProductList() {
                axios.get('api/products').then((res) => {
                    this.tempList = res.data.product;
                    for(let index in this.tempList)
                    {
                        if(this.tempList[index].amount !== 0)
                        {
                            this.list.push(this.tempList[index]);
                        }
                    }
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
                    this.numberOfItems++;
                    EventBus.$emit('numberOfItems', this.numberOfItems);
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
    .amount {
        width: 60px;
    }
    .table {
        width: 50%;
    }
</style>