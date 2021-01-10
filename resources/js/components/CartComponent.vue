<template>
    <section class="container mx-auto">
        <h1>Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">產品名稱</th>
                    <th scope="col">價格</th>
                    <th scope="col">數量</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="data in apidata">
                    <th scope="row">{{ data.item['name'] }}</th>
                    <td>{{ data.item['price'] }}元</td>
                    <td>{{ data.qty }}</td>
                    <td>
                        <a href="#">+</a>
                        <a href="#">-</a>
                        <a href="#">刪除</a>
                    </td>
                </tr>

            </tbody>
        </table>

        <p>總數量:{{ totalQty }}</p>
        <p>總金額:{{ totalPrice }}元</p>
        <a href="#" class="btn btn-primary">去結帳</a>
    </section>

</template>

<script>
import axios from 'axios'
export default{
    name:"book",
    data(){
        return {
            apidata:1,
            totalQty:1,
            totalPrice:1
        }
    },
    mounted(){
        axios.get("getcart").then((res) => {
            let self = this
            console.log(res);
            console.log(res.data);
            console.log(res.data.product);
            self.apidata = res.data.product
            self.totalQty = res.data.totalQty
            self.totalPrice = res.data.totalPrice

        }).catch((err) => {
            console.error(err);
        });
    }
}
</script>
