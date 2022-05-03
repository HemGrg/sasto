<template>
  <div>
       <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <nav>
                    <a href="">
                        <img class="logo" src="/images/logo.png" alt="logo">
                    </a>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="otp-form-wrapper">
                    <h3 class="text-center">OTP Verification</h3>
                    <p style="text-align:center;"><error v-if="error" :error="error"/></p> 
                     <div style="text-align:center; front-size: 40px;" v-if="loading">Sending....</div>
                    <p class="otp-verification-status">
                        We've sent a verification code/link to your email
                    </p>
                    <form @submit.prevent="onSubmit">
                        <div class="captcha">
                            <input class="input" type="number" v-for="(ot, index) in otp" :key="index"
                            v-model="otp[index]" ref="input" :style="{borderBottomColor: index
                            <= otIndex ? '#333' : ''}" @input="e => {onInput(e.target.value, index)}"
                            @keydown.delete="e =>{onKeydown(e.target.value,index)}"
                            @focus="onFocus">
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios';
import error from '../vendorLogin/Error.vue'
export default {
    name:'VerificationCode',
    components:{ error },
   data(){
     return{
       otp:['','','','','',''],
       loading: false,
       error: ''
     }
   },
   computed:{
       otpSize(){
           return this.otp.length;
       },
       otIndex(){
           let i = this.otp.findIndex(item => item === '');
           i = (i + this.otpSize)% this.otpSize;
           return i;
       },
       lastCode(){
           return this.otp[this.otpSize-1];
       }
   },
   watch:{
       otIndex(){
           this.resetCaret();
       },
       lastCode(val){
           if(val){
               console.log('this.otpSize', this.otpSize)
               this.$refs.input[this.otpSize-1].blur();
               this.onSubmit();
           }
       }
   },
   mounted(){
       this.resetCaret();
   },
   methods:{
       onInput(val,index){
           val = val.replace(/\s/g,'');
           if(index == this.otpSize-1){
               this.otp[this.otpSize-1] = val[0] //the last code/only one charaotper is allouded
           }else if(val.length>1){
               let i = index;
               for(i = index; i < this.otpSize && i-index < val.length; i++){
                   this.otp[i] = val[i];
               }
               this.resetCaret();
           }
       },
       //reset the cruser position
       resetCaret(){
           this.$refs.input[this.otpSize-1].focus();
       },
       onFocus(){
           //listen to the focus event and reposition the cursor 
            let index = this.otp.findIndex(item => item === '');
            index = (index + this.otpSize)% this.otpSize;
            console.log(this.$refs.input);
            this.$refs.input[index].focus();
       },
       onKeydown(val, index){
           if(val ===''){
               //Delete the value in the previous input and focus on it
               if(index>0){
                   this.otp[index-1] ='';
                   this.$refs.input[index-1].focus();
               }
           }
       },
     async onSubmit(){
       this.loading = true;
       try{ const response = await axios.post('api/vendor/verification-code/{code}',{
         otp: this.otp.join('')
       })
       if (response.status === 200){
            this.$router.push('/');
         }
       }catch(e){
           this.loading = false;
           this.error = "Invalied!";
       }
     }
   },
}
</script>

<style>

.captcha{
    display: flex;
    justify-content: center;
    margin-top: 40px;
}
.input{
    margin-right: 20px;
    width: 45px;
    text-align: center;
    border: none;
    border-bottom: 1px solid #eee;
    font-size: 24px;
    outline: none;
}
.input :last-of-type{
    margin-right: 0;
}
.input:disabled{
    color: #000;
    background-color: #fff;
}
.msg{
    text-align: center;
}
</style>