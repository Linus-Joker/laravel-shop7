<template>
  <div class="container">
    <div class="row justify-content-around">
      <div
        class="card text-center mt-3"
        style="width: 18rem"
        v-for="data in apidata"
        :key="data.id"
      >
        <img
          class="card-img-top"
          :src="'images/' + data.product_image.image_name"
          alt="Card image cap"
        />

        <div class="card-body">
          <h5 class="card-title">產品名稱:{{ data.name }}</h5>
          <p class="card-text pro_des">產品簡述:{{ data.description }}</p>
          <p class="card-text pro_price">
            產品價格:
            <span>{{ data.price }}</span>
            <span>元</span>
          </p>
          <!-- <a :href="'/addcart/' + data.id" class="btn btn-primary btn-lg btn-block">Add Cart</a> -->
          <button
            class="btn btn-primary btn-lg btn-block"
            @click="addcart(data.id)"
          >
            加入購物車
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "book",
  data() {
    return {
      apidata: [],
    };
  },
  mounted() {
    axios
      .get("/api/v1/products")
      .then((res) => {
        let self = this;
        console.log(res);
        console.log(res.data.data);
        self.apidata = res.data.data;
      })
      .catch((err) => {
        console.error(err);
      });
  },
  methods: {
    addcart: function (id) {
      // alert(id)
      axios
        .get("addcart/" + id)
        .then((res) => {
          let self = this;
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
