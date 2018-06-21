<template>
    <div class='row'>
        <h1>My Cart</h1>
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Price</th>
                <th>Amount</th>
                <th></th>
            </tr>
            <tr v-for="(product, index) in cartList" >
                <td>{{ product.id }}</td>
                <td>{{ product.title }}</td>
                <td>{{ product.price }}</td>
                <td><input class="amount" type="number" id="quantity" min="1" v-model="product.amount"></td>
                <td> <button @click="removeItem(product, index)" class="btn btn-danger btn-xs pull-right">Delete Item</button></td>
            </tr>
        </table>
        <p>Total Price: {{this.total}}</p>
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
                        this.total += (parseInt(item.price) * item.amount);
                    }
                });
            },
            removeItem(product, index) {
                axios.delete('api/mycart/' + product.id).then((res) => {
                    this.cartList.splice(index, 1);
                    console.log(this.cartList);
                });
            },
            changeAmount(product, index) {
                axios.put('api/mycart', product).then((res) => {

                });
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