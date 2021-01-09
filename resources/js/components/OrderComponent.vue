<template>
    <section class="container mx-auto">
        <h1 class="">Order Page</h1>
        <h3 class="">Order Info</h3>
        <table class="table">
            <thead>
                <th class="px-4 py-2">產品名稱</th>
                <th class="px-4 py-2">價格</th>
                <th class="px-4 py-2">數量</th>
                <th class="px-4 py-2">Total</th>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="border px-4 py-2">book1</td>
                    <td class="border px-4 py-2">100 NT$</td>
                    <td class="border px-4 py-2">1</td>
                    <td class="border px-4 py-2">100 NT$</td>
                </tr>
            </tbody>
        </table>

        <h3 class="">User Info</h3>

        <form method="POST" action="/orders" class="">
            <div class="mb-3">
                <label class="mb-2" for="name">
                    Name:
                </label>
                <input
                    class="border rounded py-2 px-3"
                    name="name" id="name" type="text" placeholder="name">
            </div>
            <div class="mb-3">
                <label class="mb-2" for="email">
                    Email:
                </label>
                <input
                    class="border rounded py-2 px-3"
                    name="email" id="email" type="email" placeholder="email">
            </div>
            <div class="d-flex justify-content-between">
                <button
                    class="btn btn-primary text-white py-2 px-4 rounded"
                    type="submit">
                    Submit Order
                </button>
            </div>

        </form>

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
