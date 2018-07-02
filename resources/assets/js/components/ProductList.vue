<template>
    <div class='row'>
        <div class="col">
            <h1>Our Products</h1>
            <p v-if='list.length === 0'>No Available Products!</p>

            <div class="search-wrapper">
                <input class="form-control search-input" type="text" v-model="search" placeholder="Search by title"/>
            </div>
            <div class="row">
                <div class="col-auto" v-if='product.amount !== 0' v-for="(product, index) in filteredList">
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
                            <button @click="addToCart(product, index)" :disabled="product.isincart || isAdded[index]" class="btn btn-success" data-toggle="modal" data-target="#changeModal">
                                {{ btnTitle[index] }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeModalTitle">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ messageToShow }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
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
                btnTitle: [],
                showAlert: [],
                messageToShow: '',
                search: '',
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

                            this.showAlert[index] = false;
                        }
                    }
                    console.log( this.list);
                });
            },
            addToCart(product, index) {
                this.cartData.productId = product.id;
                this.cartData.amountToBuy = parseInt(this.amountToBuy[index]);
                console.log(this.cartData);

                if(!this.cartData.amountToBuy || this.cartData.amountToBuy.length === 0 || this.cartData.amountToBuy === 0){
                    this.message[index] = 'Choose Amount To Buy';
                    this.messageToShow = this.message[index];
                }
                else if(this.cartData.amountToBuy <= this.list[index].amount)
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
                    if(this.cartData.amountToBuy === 1)
                    {
                        this.message[index] =  this.cartData.amountToBuy + ' ' + product.title + ' Added To Your Cart';
                    }
                    else {
                        this.message[index] =  this.cartData.amountToBuy + ' ' + product.title + 's Added To Your Cart';
                    }
                    this.messageToShow = this.message[index];
                    this.isAdded[index] = true;
                    this.btnTitle[index] = 'In Cart';
                    this.numberOfItems++;
                    EventBus.$emit('numberOfItems', 1);

                }
                else if(this.cartData.amountToBuy !== 0){
                    this.message[index] = 'Not Enough In Stock';
                    this.messageToShow = this.message[index];
                    this.amountToBuy[index] = '';
                    console.log(this.message[index]);
                }


            },

        },
        computed: {
            filteredList() {
                return this.list.filter(product => {
                    return product.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }

    }
</script>

<style scoped>

</style>

