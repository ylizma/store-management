<template>
    <div>
                <div  style="margin-top:5px;" v-if="alert" class="alert alert-danger alert-dismissible" role="alert">
                   <center>Vos informations sont incorrectes !!</center> 
              <button type="button" @click="" class="close" ><span aria-hidden="true">&times;</span></button>
  

    </div>
	<div class="login-container">

 <div class="row">
                <div class="col-md-6 login-form-1">
                	<center>
                		<img v-bind:src="logo" style="width:45%;">
                	</center>
                    
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <input v-model="username" type="text" class="form-control" required="" placeholder=" Email *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" v-model="password" required="" class="form-control" placeholder=" Password *" value="" />
                        </div>
                        <center>
                            <button type="submit" class="btn btn-info">Login</button>
                        </center>
                        
                    </form>
                </div>
            </div>
            </div>
            </div>
</template>
<script >
	import axios from 'axios';
export default{
	data(){
		return{
			logo: '/logo.png',
            username:'',
            password:'',
            alert:false
		}
	},
    methods:{
        login(){
            let vm=this;
            vm.$Progress.start()
            this.$store.dispatch('retreiveToken',{
                username:this.username,
                password:this.password
            }).then(response=>{
                vm.$Progress.finish()
                vm.$router.push('/produit');
            }).catch(function (err) {
                    vm.alert=true;
                    vm.$Progress.fail()
            })
        }
    }
}

</script>
<style >
	.login-container{
    margin-top: 5%;
    margin-bottom: 5%;
    margin-left: 35%;
}
.login-form-1{
    padding: 5%;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-1 h3{
    text-align: center;
    color: #333;
}
.login-form-2{
    padding: 5%;
    background: #0062cc;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-2 h3{
    text-align: center;
    color: #fff;
}
.login-container form{
    padding: 10%;
}
.btnSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
.login-form-1 .btnSubmit{
    font-weight: 600;
    color: #fff;
    background-color: #0062cc;
}
.login-form-2 .btnSubmit{
    font-weight: 600;
    color: #0062cc;
    background-color: #fff;
}
.login-form-2 .ForgetPwd{
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}
.login-form-1 .ForgetPwd{
    color: #0062cc;
    font-weight: 600;
    text-decoration: none;
}

</style>