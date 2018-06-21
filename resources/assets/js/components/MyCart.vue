<template>
    <div class='row'>
        <h1>My Cart</h1>
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
            <tr v-for="(product, index) in cartList">
                <td>{{ product.title }}</td>
                <td>{{ product.price }}</td>
                <td> <input class="amount" type="number" id="quantity" min="1" v-model="product.amount"></td>
                <td><button @click="changeAmount(product, index)" class="btn btn-danger btn-xs pull-right">Update Amount</button></td>
                <td> <button @click="removeItem(product)" class="btn btn-danger btn-xs pull-right">Delete Item</button></td>
            </tr>
        </table>
        <p>Total Price: {{this.total}}</p>
     <!--   <ul class="list-group">
            <li v-if='cartList.length === 0'>Empty Cart</li>
            <li v-if='product.amount !== 0' class="list-group-item" v-for="(product, index) in cartList">
                {{ product.title }}
                {{ product.price }}

                &lt;!&ndash;{{ product.img }}&ndash;&gt;
                <label for="quantity">Amount</label>


                <button @click="removeItem(product)" class="btn btn-danger btn-xs pull-right">Delete Item</button>
            </li>
        </ul>-->
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
            removeItem(product) {
                //axios.delete('api/mycart/');
            },
            changeAmount(product, index) {
               /* axios.post('api/mycart', this.cartData).then((res) => {
                });*/
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