<template>
    <div class="container">
        <div class="row">
            <div class="card" style="width: 18rem;" v-for="data in apidata">
                <img class="card-img-top" src="" alt="Card image cap">

                <div class="card-body">
                    <h5 class="card-title">{{ data.name }}</h5>
                    <p class="card-text pro_des">{{ data.description }}</p>
                    <p class="card-text pro_price">價格:
                    <span>{{ data.price }}</span>
                    <span>元</span>
                    </p>
                    <a href="#" class="btn btn-primary">Add Cart</a>
                </div>
            </div>
        </div>
    </div>
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
