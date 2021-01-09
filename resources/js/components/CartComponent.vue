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
                <tr>
                    <th scope="row">book1</th>
                    <td>100元</td>
                    <td>1</td>
                    <td>
                        <a href="#">+</a>
                        <a href="#">-</a>
                        <a href="#">刪除</a>
                    </td>
                </tr>

                <tr>
                    <th scope="row">book3</th>
                    <td>100元</td>
                    <td>1</td>
                    <td>
                        <a href="#">+</a>
                        <a href="#">-</a>
                        <a href="#">刪除</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>總數量:</p>
        <p>總金額:</p>
    </section>

</template>

<script>
import axios from 'axios'
export default{
    name:"book",
    data(){
        return {
            apidata:[]
        }
    },
    mounted(){
        axios.get("api/v1/products").then((res) => {
            let self = this
            console.log(res);
            console.log(res.data.data);
            self.apidata = res.data.data
        }).catch((err) => {
            console.error(err);
        });
    }
}
</script>
