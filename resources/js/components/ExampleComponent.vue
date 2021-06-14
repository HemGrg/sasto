<template>
    <div>
        <div v-if="loading">
            <h1>loading...</h1>
        </div>
        <h1>Menu</h1>
        <form class="col-sm-6" enctype="multipart/form-data" @submit.prevent="onSubmit()">
          <input-page label="Name" type="text" v-model="userName"></input-page>
          <input-page label="email" type="email" v-model="email"></input-page>
          <input-page label="password" type="password" v-model="password"></input-page>
        <div class="reset-button">
            <input type="submit" class="btn btn-success" value="Add Admin ">
        </div>
    </form>
    <router-view></router-view>
    </div>

</template>

<script>
import Input from './Input.vue';
    export default{
  components: { Input },
        data(){
        return{
           userName :'',
           email :'',
           password: '',
           loading: false
        }
    },
    methods: {
        onSubmit(){
            this.loading = true
            setTimeout(()=>{
                this.loading = false
                this.$router.push('/my-new-vue-route')

            }, 3000);
            
        }
    }
    }
</script>
