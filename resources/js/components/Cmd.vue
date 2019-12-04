<template>
	<div style="margin-top:30px;">

     <div v-if="alert" class="alert alert-success alert-dismissible" role="alert">
       <center>{{message}}</center> 
  <button type="button" @click="alertinit" class="close" ><span aria-hidden="true">&times;</span></button>
  
</div>


 <div v-if="show" style="border:solid grey 1px;border-radius:4px;padding:9px;width:50%;margin: auto;">
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Client :</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01" v-model="client_id" required="">
                    <option selected v-bind:value="0">Choose...</option>
                    <option v-for="c in clients" v-bind:value="c.id">{{c.nom }} {{c.prenom }}</option>
                  </select>
          </div>
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Produit :</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01" v-model="produit.label" required>
                    <option selected v-bind:value="{ id: 0, text: '' }">Choose...</option>
                    <option v-for="c in produits" v-bind:value="{ id: c.id, text: c.design }">{{c.design }}</option>
                  </select>
          </div>
                    <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Quantite :</label>
                  </div>
                <input type="number" class="form-control" id="recipient-name" required v-model="produit.quantity">        
                <button  type="button" style="margin-left:3px;" class="btn btn-success btn-sm" v-on:click="addproduct()">Ajouter produit</button>

          </div>

      
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Produit</th>
        <th>quantité</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="pro in sproduits" :key="pro.id">
        <td>{{pro.label.text}}</td>
        <td>{{pro.quantity}}</td>
        <td>
          <button  type="button" v-on:click="deleteproduct(pro)" style="margin-left:3px;" class="btn btn-danger btn-sm" >Delete</button>
        </td>
      </tr> 
    </tbody>
  </table>
      

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="show=false;showbtnadd=true;">Close</button>
        <button  type="button" class="btn btn-warning " id="update">Update</button>
        <button  type="submit" class="btn btn-primary" @click="savecmd">Enregistrer la commande</button>
      </div>
    </div>

 <button v-if="showbtnadd" type="button" class="btn btn-info" v-on:click="show = true;showBtnU=false;showBtnS=true;showbtnadd=false;" style="margin-top:6px;">Ajouter une commande</button><br><br>

    <div class="input-group mb-3" style="width:250px;margin-top:10px;">
  <div class="input-group-prepend">
<button class="btn btn-outline-info"  v-on:click="find" type="button"  id="button-addon1">chercher</button>
  </div>
  <input type="text"  class="form-control" v-model="search"  aria-label="Example text with button addon" aria-describedby="button-addon1">

</div>



   <br/>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom client</th>
            <th>N° cmd</th>
            <th>Date</th>
            <th>Total(ht)</th>
            <th>Détails</th>
         
        </tr>
    </thead>
    <tbody>
        <tr v-for="c in cmds ">
            <td>{{c.client.prenom}} {{c.client.nom}}</td>
            <td>{{c.num}}</td>
            <td>{{c.created_at}}</td>
            <td>{{c.totalHT}} DH</td>
            <td>
      <button type="button" @click="getcmdbyId(c.id)"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" disabled="" >Détail</button>
      <button type="button" @click="deletecmd(c.id)"  class="btn btn-danger btn-sm" >Delete</button>
      <router-link class="btn btn-warning btn-sm" v-bind:to="'/fact/'+c.id">Imprimer</router-link>
            </td>

        </tr>
    </tbody>
</table>
<nav aria-label="..." style="margin-left:50%;">
  <ul class="pagination">
    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
      <a class="page-link"  tabindex="-1" @click="fetchcmds(pagination.prev_page_url)">Previous</a>
    </li>
<li class="disabled page-item text-dark"><a class="page-link" >Page : {{pagination.current_page}} of {{pagination.last_page}} </a></li>

    <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
      <a @click="fetchcmds(pagination.next_page_url)" class="page-link" >Next</a>
    </li>
  </ul>
</nav>
</div>



</template>
<script>
	export default{
		data(){
			return {
				show:false,
        showbtnadd:true,
        search:'',
        alert:false,
        message:'',
        client_id:0,
        clients:[],
        produits:[],
        sproduits:[],
        cmds:[],
        showBtnU:false,
        showBtnS:true,
        pagination: {},
        produit:{
          label:'',
          quantity:''
          
        },
			}
		},

		created(){
      this.$Progress.start()
      this.fetchinfos();
      this.fetchcmds();
		},
    mounted(){
      this.$Progress.finish()
    },
    methods: {
      addproduct(){
        if (this.produit.label==='' || this.produit.quantity==0) {
          alert("essayer d'ajouter le produit et la quantié")
        }else{
        this.sproduits.push(this.produit);
        console.log(this.sproduits);
        this.produit={};
         }
      },
      deleteproduct(produit) {
      const produitIndex = this.sproduits.indexOf(produit);
      this.sproduits.splice(produitIndex, 1);
    },
    fetchinfos(){
      fetch('api/produits').then(res=>res.json()).then(res=>{
                this.produits=res.data;
            });
      fetch('api/clients').then(res=>res.json()).then(res=>{
                this.clients=res.data;
            });
    },

    fetchcmds(page_url){
      let vm=this;
      vm.$Progress.start()
            page_url=page_url || '/api/lcmds';
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.cmds=res.data;
                console.log(res.data);
               vm.makepagination(res.meta,res.links);
               this.$Progress.finish()
            });
    },
    find(){
    let vm=this
    vm.$Progress.start()
        axios.post('/api/lcmd/search',{
              nom:vm.search,  
          }).then(response=>{
            console.log(response.data.data);
              vm.cmds=response.data.data;
             vm.$Progress.finish()
          }).catch(error=>{
              console.log(error);
          })
      },
     makepagination(meta,links){
        let pagination={
            current_page:meta.current_page,
            last_page:meta.last_page,
            next_page_url:links.next,
            prev_page_url:links.prev
        }
        this.pagination=pagination;
    },
    savecmd(){
      var vm=this;

      if (this.client_id ==null || !this.sproduits.length > 0) {
        // alert("Essayer de choisir le client");
        alert("Essayer de choisir le client Ou de ajouter un produit au liste")
      }
      else{
        vm.$Progress.start()
      let cmd={
        products:this.sproduits,
        client_id:this.client_id
      }
      console.log(cmd)
      axios.post('/api/lcmd',{
              products:this.sproduits,
              client_id:this.client_id
          }).then(response=>{
            this.show=false;
            this.showbtnadd=true;
            this.fetchcmds();
            this.sproduits=[];
            vm.alert=true;
            vm.message='La commande est bien enregistrée !!!';
            vm.$Progress.finish()
          }).catch(error=>{
              console.log(error);
          })
      }
    },

        deletecmd(id){
       var vm=this;
       vm.$Progress.start()
        if (confirm('vous etes sur ?!')) {
            fetch('api/lcmd/'+id,{
                method:'delete'
            }
                ).then(res=>res.json).then(data=>{
                    this.fetchcmds();
              vm.alert=true;
            vm.message='La commande est bien supprimée !!!';
            vm.$Progress.finish()
                });
            }
        },


        alertinit(){
        
        this.alert=false;
        this.message='';
    }
    }
	}
</script>
