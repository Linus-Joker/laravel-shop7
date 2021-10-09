<template>
  <div class="container">
    <div class="row">
      <!-- 卡片開始 -->
      <div class="card" style="width: 18rem">
        <img class="card-img-top" alt="Card image cap" />

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
          <button class="btn btn-primary btn-lg btn-block">加入購物車</button>
        </div>
      </div>
      <!-- 卡片結束 -->
    </div>

    <p>商品留言:</p>
    <div v-for="message in api_message_data" :key="message.id">
      <p>
        留言 <span>用戶 {{ message.user_id }} Name:</span>
      </p>
      <p>{{ message.message_content }}</p>
      <p>管理員回復:{{ id }}</p>
      <p>{{ message.res_content }}</p>
      <p>-----------------------------------</p>
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
    };
  },

  //因為我要用參數去請求api，所以這裡要抓到外部傳過來的參數
  mounted() {
    let id = this.product_id;
    let self = this;
    let curPageUrl = window.document.location.href;
    var rootPath =
      curPageUrl.split("//")[0] +
      "//" +
      curPageUrl.split("//")[1].split("/")[0] +
      "/" +
      curPageUrl.split("//")[1].split("/")[1] +
      "/" +
      curPageUrl.split("//")[1].split("/")[2] +
      "/";

    //單個商品的請求
    axios.get(rootPath + "api/v1/item/" + id).then((res) => {
      // console.log(res);
      // console.log(res.data.data);
      // console.log(res.data.data.product_image["image_name"]);
      self.api_product_data = res.data.data;
    });

    //留言功能請求
    axios.get(rootPath + "api/v1/item/message/" + id).then((res) => {
      // console.log(res);
      self.api_message_data = res.data.data;
    });
  },
};
</script>

