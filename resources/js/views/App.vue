<template>
	<div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img v-bind:src="logo" width="50" height="35" class="d-inline-block align-top" alt="">
    <big style="margin-left:10px">ZITO</big>  <small>sarl</small>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
    <div class="navbar-nav">
     <router-link v-if="logedIn" to="/produit" class="nav-item nav-link">Produits</router-link>
     <router-link v-if="logedIn" to="/stock" class="nav-item nav-link">Stock</router-link>
     <router-link v-if="logedIn" to="/cat" class="nav-item nav-link">Categories</router-link>
	 <router-link v-if="logedIn" to="/client" class="nav-item nav-link">Clients</router-link>
	 <router-link v-if="logedIn" to="/cmd" class="nav-item nav-link">Commandes</router-link>
<!--    <router-link v-if="logedIn" to="/logout" class="btn btn-outline-info my-2 my-sm-0 right ml-md-auto" >Logout</router-link>
 -->   <button v-if="logedIn" class="btn btn-outline-info" @click="logout">Logout</button>
    </div>
  </div>
</nav>
<div class="container">
	<router-view/>
  <vue-progress-bar></vue-progress-bar>
</div>

</div>
</template>
<script type="text/javascript">
	export default{
    data(){
      return{
        logo:'/logo.png'
      }
    },
    computed:{
      logedIn(){
        return this.$store.getters.logedIn;
      }
    },
    methods:{
      logout(){ 
        let vm=this
        this.$store.dispatch('destroyToken').
      then(response=>{
        this.$router.push('/login');
      }).catch(response=>{
        this.$router.push('/login');
      })
      }
    }
  };
</script>