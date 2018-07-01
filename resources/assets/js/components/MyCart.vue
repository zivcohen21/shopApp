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
                        <td class="align-middle text-center">{{ item.price }}</td>
                        <td class="align-middle text-center">{{ currAmount[index] }}</td>
                        <td class="align-middle text-center"><input class="amount form-control" type="number" id="quantity" min="1" v-model="item.amount">
                           <p> {{ message[index] }}</p>
                        </td>
                        <td class="align-middle text-center"><button @click="changeAmount(item, index)" class="btn btn-warning">Change Amount</button></td>
                        <td class="align-middle text-center"><button @click="removeItem(item, index)" class="btn btn-danger">Delete Item</button></td>
                    </tr>
                </tbody>
            </table>
            <p>Total Price: {{total}}</p>
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
                        this.message[index] = '';
                    }
                });
            },
            removeItem(item, index) {
                axios.delete('api/mycart/' + item.id).then((res) => {
                    this.total -= (parseInt(item.price) * this.currAmount[index]);
                    this.cartList.splice(index, 1);
                    this.currAmount.splice(index, 1);
                    this.message.splice(index, 1);
                    EventBus.$emit('numberOfItems', 0);
                });
            },
            changeAmount(item, index) {
                if(item.amount <= item.maxAmount)
                {
                    let difAmount = this.currAmount[index] - item.amount;
                    this.currAmount[index] = item.amount;
                    console.log(this.currAmount[index] );
                    this.total -= parseInt(item.price) * difAmount;
                    axios.put('api/mycart/' + item.id, item).then((res) => {

                    });
                }
                else {
                    this.total += 1;
                    this.total -= 1;
                    this.message[index] = 'Not Enough In Stock';
                    console.log(this.message[index]);
                }
            }
        }
    }
</script>

<style scoped>

</style>