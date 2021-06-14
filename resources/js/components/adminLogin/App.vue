<template>
  <div>
      <div v-if="initiated">
          <router-view @onUserChanged="updateUser"></router-view>
        </div>
  </div>
</template>

<script>
export default {
    name:"App",
    data:()=>{
        return{
            initiated:false,
            user: null
        }
    },
    async mounted(){
        await this.init();
    },
    methods:{
        async init(){
             const {data} = await axios.get("/auth/init");
             this.user = data.user;
             this.initiated = true;
        },
        updateUser(){
            console.log(user);
            this.user = user
        }
    }


}
</script>

<style>

</style>