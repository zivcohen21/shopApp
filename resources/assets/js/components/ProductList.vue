<template>
    <div class='row'>
        <div class="col">
            <h1>Our Products</h1>
            <p v-if='list.length === 0'>No Available Products!</p>
           <!-- <table class="table table-hover" v-if='list.length !== 0'>
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Price</th>
                    <th scope="col">In Stock</th>
                    <th scope="col">Amount To Buy</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if='product.amount !== 0' v-for="(product, index) in list">
                    <td class="align-middle text-center"><img :src="product.img" class="img-fluid" width="180px"></td>
                    <td class="align-middle">{{ product.title }}</td>
                    <td class="align-middle">{{ product.price }}</td>
                    <td class="align-middle">{{ product.amount }}</td>
                    <td class="align-middle"> <input class="amount" type="number" id="quantity" min="1" v-model="amountToBuy[product.id]" :disabled="product.isincart || isAdded[index]"></td>
                    <td class="align-middle"> <button @click="addToCart(product, index)" :disabled="product.isincart || isAdded[index]" class="btn btn-success">
                        {{ btnTitle[index] }}
                    </button></td>
                    <td>{{ message[index] }}</td>
                </tr>
                </tbody>

            </table>-->
            <div class="row">
                <div class="col-auto" v-if='product.amount !== 0' v-for="(product, index) in list">
                    <div class="card">
                        <img class="card-img-top img-fluid" :src="product.img" alt="Card image cap">
                        <div class="card-body title-part">
                            <div class="card-title text-center">{{ product.title }}</div>
                        </div>
                        <ul class="list-group list-group-flush font-weight-light price-amount">
                            <li class="list-group-item">Price: <span class="badge badge-primary">{{ product.price }}$</span></li>
                            <li class="list-group-item">In Stock:  <span class="badge badge-secondary">-{{ product.amount }}-</span></li>
                        </ul>
                        <div class="card-body font-weight-light">
                            <label for="quantity">Amount To Buy: </label>
                            <input class="amount form-control" type="number" id="quantity" min="1" v-model="amountToBuy[index]" :disabled="product.isincart || isAdded[index]">
                        </div>
                        <div class="wrapper-btn">
                            <button @click="addToCart(product, index)" :disabled="product.isincart || isAdded[index]" class="btn btn-success">
                                {{ btnTitle[index] }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    amount: 0,
                    isincart: false
                },
                cartData: {
                    productId: '',
                    amountToBuy: 0
                },
                amountToBuy: [],
                message: [],
                numberOfItems: 0,
                isAdded: [],
                btnTitle: []
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
                            if(!this.tempList[index].isincart)
                            {
                                this.btnTitle[index] = 'Add To Cart';
                            }
                            else
                            {
                                this.btnTitle[index] = 'In Cart';
                            }
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
                    this.isAdded[index] = true;
                    this.btnTitle[index] = 'In Cart';
                    this.amountToBuy[product.id] = '';
                    this.numberOfItems++;
                    EventBus.$emit('numberOfItems', 1);
                }
                else {
                    this.message[index] = 'Not Enough In Stock';
                    this.amountToBuy[product.id] = '';
                    console.log(this.message[index]);
                }
            },
        }
    }
</script>

<style scoped>

</style>

