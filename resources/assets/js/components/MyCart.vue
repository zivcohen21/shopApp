<template>
    <div class='row'>
        <h1>My Cart</h1>
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Change Amount</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-for="(item, index) in cartList" >
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.price }}</td>
                <td>{{ currAmount[index] }}</td>
                <td><input class="amount" type="number" id="quantity" min="1" v-model="item.amount"></td>
                <td><button @click="changeAmount(item, index)" class="btn btn-warning btn-xs pull-right">Change Amount</button></td>
                <td><button @click="removeItem(item, index)" class="btn btn-danger btn-xs pull-right">Delete Item</button></td>
                <td>{{ message[index] }}</td>
            </tr>
        </table>
        <p>Total Price: {{this.total}}</p>
    </div>
</template>

<script>

    import axios from 'axios';
    import { EventBus } from '../event-bus';
    export default {
        data() {
            return {
                list: [],
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
            };
        },

        created() {
            this.fetchCartList();
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
                    }
                });
            },
            removeItem(item, index) {
                axios.delete('api/mycart/' + item.id).then((res) => {
                    this.cartList.splice(index, 1);
                    this.total -= parseInt(item.price) * item.amount;
                    EventBus.$emit('numberOfItems', 0);
                });
            },
            changeAmount(item, index) {
                if(item.amount <= item.maxAmount)
                {
                    axios.put('api/mycart/' + item.id, item).then((res) => {

                    });
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