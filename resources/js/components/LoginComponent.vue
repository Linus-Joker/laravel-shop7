<template>
  <div class="container">
    <div class="row justify-content-center">
      <p>我是登入</p>
      <div>
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
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
            <label for="exampleInputPassword1">Password</label>
            <input
              type="password"
              class="form-control"
              id="exampleInputPassword1"
              placeholder="Password"
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
    };
  },
  mounted() {},
  methods: {
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
          if (res.status === 200) {
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
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
