<template>
  <section class="container mx-auto">
    <h1 class="">Order Page</h1>
    <h3 class="">Order Info</h3>
    <table class="table">
      <thead class="text-center">
        <th class="px-4 py-2">產品名稱</th>
        <th class="px-4 py-2">價格</th>
        <th class="px-4 py-2">數量</th>
        <th class="px-4 py-2">Total</th>
      </thead>
      <tbody class="text-center">
        <tr v-for="data in apidata" :key="data.id">
          <th scope="row">{{ data.item["name"] }}</th>
          <td>{{ data.item["price"] }}元</td>
          <td>{{ data.qty }}</td>
          <td class="border px-4 py-2">{{ data.price }} 元</td>
        </tr>
      </tbody>
    </table>
    <p>總金額:{{ totalPrice }}元</p>

    <h3 class="">User Info</h3>

    <form method="POST" @submit="checkForm" action="" class="">
      <div class="mb-3">
        <label class="mb-2" for="name"> Name: </label>
        <input
          class="border rounded py-2 px-3"
          name="name"
          id="name"
          type="text"
          placeholder="name"
        />
      </div>
      <div class="mb-3">
        <label class="mb-2" for="email"> Email: </label>
        <input
          class="border rounded py-2 px-3"
          name="email"
          id="email"
          type="email"
          placeholder="email"
        />
      </div>
      <div class="d-flex justify-content-between">
        <button
          class="btn btn-primary text-white py-2 px-4 rounded"
          type="submit"
        >
          Submit Order
        </button>
        <button disabled="disabled">123</button>
      </div>
    </form>
  </section>
</template>

<script>
import axios from "axios";
export default {
  name: "book",
  data() {
    return {
      apidata: 1,
      totalPrice: 1,
    };
  },
  mounted() {
    axios
      .get("getorder")
      .then((res) => {
        let self = this;
        // console.log(res);
        // console.log(res.data);
        // console.log(res.data.product);
        // self.apidata = res.data.product;
        // self.totalPrice = res.data.totalPrice;
      })
      .catch((err) => {
        console.error(err);
      });
  },
  methods: {
    checkForm: function (e) {
      e.preventDefault();
      let name = "milk";
      let email = "123@mail.com";

      console.log(name);
    },
  },
};
</script>
