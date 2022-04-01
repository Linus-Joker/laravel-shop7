<template>
  <div class="container">
    <div class="row justify-content-center">
      <p>我是註冊,</p>
      <div>
        <form @submit.prevent="register">
          <div class="form-group">
            <label for="exampleInputEmail1">電子郵件</label>
            <input
              type="text"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              placeholder="Enter email"
              v-model="email"
            />
            <small id="emailHelp" class="form-text text-muted"
              >We'll never share your email with anyone else.</small
            >
          </div>

          <div class="form-group">
            <label for="exampleInputUserName">使用者名稱</label>
            <input
              type="text"
              class="form-control"
              id="exampleInputUserName"
              placeholder="Enter UserName"
              v-model="user_name"
            />
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input
              type="password"
              class="form-control"
              id="exampleInputPassword1"
              placeholder="Enter Password"
              v-model="password"
            />
          </div>

          <button type="submit" class="btn btn-primary btn-lg btn-block">
            Submit
          </button>
        </form>
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
      email: "",
      password: "",
      user_name: "",
    };
  },
  mounted() {},
  methods: {
    //註冊
    register: function () {
      //註冊需要的資料
      let self = this;
      let account = self.email;
      let user_name = self.user_name;
      let password = self.password;

      //只做EMAIL的註冊
      axios
        .post("api/v1/member/registed/email", {
          account: account,
          user_name: user_name,
          password: password,
        })
        .then((res) => {
          console.log(res);
          //如果有註冊成功，拿到200狀態
          if (res.data.status === 200) {
            //執行登入
            self.login();
          } else {
            alert(res.data.status + "," + res.data.message);
            location.reload();
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },

    //登入
    login: function () {
      let self = this;
      let account = self.email;
      let password = self.password;

      axios
        .post("api/v1/member/login", {
          account: account,
          password: password,
        })
        .then((res) => {
          console.log(res);
          if (res.data.status === 200) {
            var getUrlString = location.href;
            //   console.log(getUrlString);
            var splitStrArray = getUrlString.split("/");
            var newStr = " ";
            for (var i = 0; i < splitStrArray.length - 1; i++) {
              //console.log(n[i])
              newStr = newStr + splitStrArray[i] + "/";
            }
            //   console.log(newStr.trim());
            window.location.replace(newStr.trim());
          } else {
            alert(res.data.status + "," + res.data.message);
            location.reload();
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
