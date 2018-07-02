<template>
    <div class='row'>
        <div class="col">
            <h1>My Cart</h1>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Title</th>
                        <th scope="col">Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Change Amount</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in cartList" >
                        <td class="align-middle text-center">{{ item.title }}</td>
                        <td class="align-middle text-center">{{ item.price }}$</td>
                        <td class="align-middle text-center">{{ currAmount[index] }}</td>
                        <td class="align-middle text-center"><input class="amount form-control" type="number" id="quantity" min="1" v-model="item.amount">
                        </td>
                        <td v-if="window.width > 600" class="align-middle text-center">
                            <button @click="changeAmount(item, index)" class="btn btn-warning" data-toggle="modal" data-target="#changeModal">Change Amount</button>
                        </td>
                        <td v-if="window.width > 600" class="align-middle text-center">
                            <button @click="tryRemoveItem(item, index)" class="btn btn-danger"  data-toggle="modal" data-target="#deleteModal">Delete Item</button>
                        </td>

                        <td v-if="window.width < 600" class="align-middle text-center">
                            <button @click="changeAmount(item, index)" class="btn btn-warning btn-cart" data-toggle="modal" data-target="#changeModal">Change Amount</button>
                            <button @click="tryRemoveItem(item, index)" class="btn btn-danger btn-cart" data-toggle="modal" data-target="#deleteModal">Delete Item</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="total-price">Total Price: {{totalString}} $</p>
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


        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalTitle">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Delete Item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button @click="removeItem()" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
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
                item: {
                    id: '',
                    title: '',
                    price: '',
                    img: '',
                    amount: 0,
                    maxAmount: 0
                },
                currAmount: [],
                message: [],
                cartList: [],
                total: 0,
                totalString: '',
                window: {
                    width: window.innerWidth,
                    height: window.innerHeight
                },
                messageToShow: '',
                toDelete: false,
                itemDelete: '',
                indexDelete: '',
            };
        },

        created() {
            this.fetchCartList();
            window.addEventListener('resize', this.handleResize);
        },

        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },

        methods: {
            fetchCartList() {
                axios.get('api/mycart').then((res) => {
                    this.cartList = res.data.item;
                    this.total = 0;
                    for(let index in this.cartList)
                    {
                        let item = this.cartList[index];
                        this.currAmount[index] = item.amount;
                        this.total += parseInt(item.price) * item.amount;

                        this.message[index] = '';
                    }
                    this.totalString = this.total.toLocaleString('en');
                });
            },
            removeItem() {

                axios.delete('api/mycart/' + this.itemDelete.id).then((res) => {
                        this.total -= (parseInt(this.itemDelete.price) * this.currAmount[this.indexDelete]);
                        this.totalString = this.total.toLocaleString('en');
                        this.cartList.splice(this.indexDelete, 1);
                        this.currAmount.splice(this.indexDelete, 1);
                        this.message.splice(this.indexDelete, 1);
                        EventBus.$emit('numberOfItems', 0);
                });

            },
            changeAmount(item, index) {

                if(!item.amount || item.amount .length === 0 || item.amount === 0){
                    this.message[index] = 'Choose Amount';
                    this.messageToShow = this.message[index];
                }
                else if(item.amount <= item.maxAmount)
                {
                    let difAmount = this.currAmount[index] - item.amount;
                    this.currAmount[index] = item.amount;
                    console.log(this.currAmount[index] );
                    this.total -= parseInt(item.price) * difAmount;
                    this.totalString = this.total.toLocaleString('en');
                    axios.put('api/mycart/' + item.id, item).then((res) => {

                    });

                    this.message[index] = "Amount Changed To " + item.amount;
                    this.messageToShow = this.message[index]
                }
                else {
                    this.message[index] = 'Not Enough In Stock';
                    this.messageToShow = this.message[index];
                    console.log(this.message[index]);
                }
            },

            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            },

            tryRemoveItem(item, index) {
                this.itemDelete = item;
                this.indexDelete = index;
            }

        }
    }

</script>

<style scoped>

</style>