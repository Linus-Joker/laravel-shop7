<template>
  <section class="container mx-auto">
    <h1>Shopping Cart</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">產品名稱</th>
          <th scope="col">單價</th>
          <th scope="col">數量</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in apidata" :key="data.id">
          <th scope="row">{{ data.item["name"] }}</th>
          <td>{{ data.item["price"] }}元</td>
          <td>{{ data.qty }}</td>
          <td>
            <!-- <a href="/add-to-cart/">+</a> -->
            <!-- <a href="#">-</a> -->
            <!-- <a href="#">刪除</a> -->
            <button v-on:click="increase(data.item[`id`])">+</button>
            <button v-on:click="decrease(data.item[`id`])">-</button>
            <button v-on:click="ddd">刪除</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p>總數量:{{ totalQty }}</p>
    <p>總金額:{{ totalPrice }}元</p>
    <a href="order" class="btn btn-primary">去結帳</a>
  </section>
</template>

<script>
import axios from "axios";
export default {
  name: "book",
  data() {
    return {
      apidata: 1,
      totalQty: 1,
      totalPrice: 1,
    };
  },
  methods: {
    increase: function (id) {
      // alert("現在的物品編號:" + id);
      axios
        .get("increase/" + id)
        .then((res) => {
          // console.log(res);
          if (res.data == 1) {
            console.log("新增成功");
            location.reload();
          } else {
            console.loh("新增失敗.");
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    decrease: function (id) {
      axios
        .get("decrease/" + id)
        .then((res) => {
          if (res.data == 1) {
            console.log("減少成功");
            location.reload();
          } else {
            console.loh("減少失敗.");
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    ddd: function () {
      location.reload();
    },
  },
  mounted() {
    axios
      .get("getcart")
      .then((res) => {
        let self = this;
        console.log(res);
        console.log(res.data);
        console.log(res.data.product);
        self.apidata = res.data.product;
        self.totalQty = res.data.totalQty;
        self.totalPrice = res.data.totalPrice;
      })
      .catch((err) => {
        console.error(err);
      });
  },
};
</script>
