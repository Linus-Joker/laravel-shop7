<template>
  <div class="container">
    <div class="row">
      <!-- 卡片開始 -->
      <div class="card" style="width: 18rem">
        <img
          class="card-img-top"
          :src="'/images/' + api_product_data.product_image[`image_name`]"
          alt="Card image cap"
        />

        <div class="card-body">
          <h5 class="card-title">產品名稱:{{ api_product_data["name"] }}</h5>
          <p class="card-text">
            產品簡述:{{ api_product_data["description"] }}
          </p>
          <p class="card-text pro_price">
            產品價格:
            <span>{{ api_product_data["price"] }}</span>
            <span>元</span>
          </p>
          <button class="btn btn-primary btn-lg btn-block" @click="addcart()">
            加入購物車
          </button>
        </div>
      </div>
      <!-- 卡片結束 -->
    </div>

    <p>商品留言:</p>
    <div v-for="message in api_message_data" :key="message.id">
      <div class="p-3 mb-2 bg-secondary text-white">
        <p>
          留言#
          <span>用戶 {{ message.user_id }} Name: {{ message.user_name }}</span>
        </p>
        <p>{{ message.message_content }}</p>
      </div>

      <!-- 如果管理員還沒回覆留言，留言暫時不顯示 -->
      <div
        class="p-3 mb-2 bg-light text-dark"
        v-if="message.res_content == null"
      ></div>
      <div class="p-3 mb-2 bg-light text-dark" v-else>
        <p>管理員{{ message.admin_id }}回復:</p>
        <p>{{ message.res_content }}</p>
      </div>
      <p>-----------------------------------</p>
    </div>

    <div>
      <div>
        <label for="">使用者留言:</label>
        <textarea type="text" v-model="user_message"></textarea>
        <button class="btn btn-success" @click="sendMessage()">送出</button>
      </div>

      <div v-if="false">
        <label for="">管理員回覆:</label>
        <textarea type="text" value="456" />
        <button type="button" class="btn btn-danger">送出</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "book",

  // 從外部接收參數要使用props
  props: ["product_id"],

  // data這裡先不管
  data() {
    return {
      id: this.product_id,
      api_product_data: [],
      api_message_data: [],
      user_message: "Hello 請輸入留言!!",
    };
  },

  //因為我要用參數去請求api，所以這裡要抓到外部傳過來的參數
  mounted() {
    let id = this.product_id;
    let self = this;

    //單個商品的請求;
    axios.get("/api/v1/item/" + id).then((res) => {
      // console.log(res);
      // console.log(res.data.data);
      // console.log(res.data.data.product_image["image_name"]);
      self.api_product_data = res.data.data;
    });

    //留言功能請求;
    axios.get("/api/v1/item/message/" + id).then((res) => {
      // console.log(res);
      self.api_message_data = res.data.data;
    });
  },
  methods: {
    sendMessage: function () {
      let self = this;
      let message_content = self.user_message;
      let product_id = self.id;
      console.log(message_content);
      console.log(product_id);

      axios
        .post("/api/v1/message", {
          message_content: message_content,
          product_id: product_id,
        })
        .then((res) => console.log(res));
    },
    addcart: function () {
      let id = this.product_id;
      axios
        .get("/addcart/" + id)
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

