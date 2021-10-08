<template>
  <div class="container">
    <div class="row">
      <!-- 卡片開始 -->
      <div class="card" style="width: 18rem">
        <img class="card-img-top" alt="Card image cap" />
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">
            Some quick example text to build on the card title and make up the
            bulk of the card's content.
          </p>
          <a class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
      <!-- 卡片結束 -->
    </div>

    <div>
      商品留言:
      <p>留言1 <span>用戶Name</span></p>
      <p>1234567</p>
      <p>管理員回復:{{ id }}</p>
      <p>987654321</p>
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
    };
  },

  //因為我要用參數去請求api，所以這裡要抓到外部傳過來的參數
  mounted() {
    let id = this.product_id;
    console.log(id);
  },
};
</script>

