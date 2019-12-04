<template>
    <div style="margin-top:30px;">   
    
     <div v-if="alert" class="alert alert-success alert-dismissible" role="alert">
       <center>{{message}}</center> 
  <button type="button" @click="alertinit" class="close" ><span aria-hidden="true">&times;</span></button>
  
</div>


        <div v-if="show" style="border:solid grey 1px;border-radius:4px;;padding:9px;width:50%;margin: auto;">


             <div v-if="existp" class="alert alert-danger alert-dismissible" role="alert">
              <center>{{ message_err }}</center> 
            </div>


        <form @submit.prevent="saveProduit">
          <div class="row">
          <div class="col">
            <label for="recipient-name" class="col-form-label">Reference :</label>
            <input type="text" class="form-control" required="" id="recipient-name" v-model="produit.ref">
          </div>
          <div class="col">
            <label for="recipient-name" class="col-form-label">Designation :</label>
            <input type="text" class="form-control" required="" id="recipient-name" v-model="produit.design">
          </div>
            </div>
            <div class="row">
          <div class="col">
            <label for="message-text" class="col-form-label">Prix de vente :</label>
            <input required type="number" class="form-control" id="recipient-name" v-model="produit.prix_vente">
          </div>
          <div class="col">
            <label for="message-text" class="col-form-label">TVA :</label>
           <input required type="number" class="form-control" id="recipient-name" v-model="produit.tva">
          </div>
          </div>
          <div class="row">
                      <div class="col">
                    <label class="col-form-label" for="inputGroupSelect01">Categorie:</label>
                  <select required class="custom-select" id="inputGroupSelect01" v-model="produit.categorie_id">
                    <option v-for="c in categories" v-bind:value="c.id">{{c.label}}</option>
                  </select>
            </div>

          <div class="col">
            <label for="message-text" class="col-form-label">Quantity :</label>
            <input required type="number" class="form-control" id="recipient-name" v-model="produit.quantity">
          </div>
          </div>
          
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="show=false">Close</button>

        <button v-if="showBtnU" v-on:click="updatedata" type="button" class="btn btn-warning " id="update">Update</button>
        <button v-if="showBtnS" type="submit" class="btn btn-primary" id="save">Enregistrer</button>

      </div>
        </form>

        </div>


         <button type="button" class="btn btn-info" v-on:click="show = true;showBtnU=false;showBtnS=true;" style="margin-top:6px;">Ajouter un produit</button>
     
    <div class="input-group mb-3" style="width:250px;margin-top:10px;">
  <div class="input-group-prepend">
<button class="btn btn-outline-info"  v-on:click="find" type="button"  id="button-addon1">chercher</button>
  </div>
  <input type="text"  class="form-control" v-model="search"  aria-label="Example text with button addon" aria-describedby="button-addon1">
</div>


   <br/>
<table class="table">
    <thead>
        <tr >
            <th>Réference</th>
            <th>Désignation</th>
            <th>prix de vente</th>
            <th>tva</th>
            <th>Stock</th>
            <th>categorie</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <tr class="" v-for="c in produits">
            <td >{{c.ref}}</td>
            <td>{{c.design}}</td>
            <td>{{c.prix_vente}}</td>
            <td>{{c.tva}}</td>
            <td>{{c.stock.current_q}} </td>
            <td >{{c.categorie.label}}</td>
            <td>
                <button type="button" v-on:click="editclick(c.id)" class="btn btn-success btn-sm"  >Edit</button>
                <button type="button" v-on:click="deleteProduit(c.id)" class="btn btn-danger btn-sm" >Delete</button>
            </td>
        </tr>
    </tbody>
</table>

<nav aria-label="..." style="margin-left:50%;">
  <ul class="pagination">
    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
      <a class="page-link"  tabindex="-1" @click="fetchProduits(pagination.prev_page_url)">Previous</a>
    </li>
<li class="disabled page-item text-dark"><a class="page-link" >Page : {{pagination.current_page}} of {{pagination.last_page}} </a></li>

    <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
      <a @click="fetchProduits(pagination.next_page_url)" class="page-link" >Next</a>
    </li>
  </ul>
</nav>

</div>



</template>

<script>


export default {
    data(){
        return {

            produits: [],
            lproduits:[],
            categories:[],
            edit:false,
            search:'',
            alert:false,
            message:'',
            existp:false,
            message_err:'',
            show:false, 
            showBtnU:false,
            showBtnS:true,
            pagination: {},
            produit: {
                id: 0,
                design: '',
                ref:'',
                prix_vente: 0,
                tva:0,
                quantity:0,
                categorie_id:0           
      },

        }
    },
    mounted(){
        this.$Progress.finish()
    },
    created(){
        this.fetchProduits();
        this.$Progress.start()
    },
    methods:{
        fetchProduits(page_url){
            let vm=this;
            vm.$Progress.start()
            page_url=page_url || '/api/produits';
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.produits=res.data;
                //console.log(this.produits.categorie);
                vm.makepagination(res.meta,res.links);
                vm.$Progress.finish()
            });
            fetch('api/categories').then(res=>res.json()).then(res=>{
                this.categories=res.data;
            });
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
    saveProduit() {
      var vm=this;
      console.log(this.produit)
      vm.$Progress.start()
      if (this.produit.prix_vente==0  || this.produit.quantity==0 ) {
        vm.$Progress.fail()
        this.message_err='la valeur 0 ne peut pas etre enregistrer !!!';
        this.existp=true;
      }
      else if (this.produit.categorie_id==null) {
        alert("Insérer le categorie")
      }
      else{
      if (this.exist(this.produit.ref,this.produit.categorie_id)) {
        vm.$Progress.fail()
        this.message_err='le Produit existe déja !!!';
        this.existp=true;
      }else{
        fetch('api/produit',{
        method: 'post',
        body: JSON.stringify(this.produit),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchProduits();
        vm.alert=true;
        vm.message='Le produit est bien enregistré !!!';
        this.existp=false;
        this.produit={};
        vm.$Progress.finish()

       });        
      }
  }

    },


    deleteProduit(id){
       let vm=this;
       vm.$Progress.start()
        if (confirm('vous etes sur ?!')) {
            
            fetch('api/produit/'+id,{
                method:'delete'
            }
                ).then(res=>res.json()).then(data=>{
                    this.fetchProduits();
                    vm.alert=true;
                    vm.message='Le produit est bien supprimé !!!';
                    vm.$Progress.finish()
                });
            }else this.fetchproduits();
            
        },
        editclick(id){
        fetch('api/produit/'+id).then(res=>res.json()).then(res=>{
                this.produit=res.data;
            })
        this.show=true;
        this.showBtnU=true;
        this.showBtnS=false;

        //this.produit_id=id;
           
    },
    updatedata(){

        let upd={
            produit_id:this.produit.id,
            design: this.produit.design,
            ref:this.produit.ref,
            prix_vente: this.produit.prix_vente,
            tva:this.produit.tva,
            quantity:this.produit.quantity,
            categorie_id:this.produit.categorie_id
        };

       var vm=this;         
       vm.$Progress.start()
       fetch('api/produit/'+this.produit.id,{
        method: 'put',
        body: JSON.stringify(upd),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchProduits();
        vm.alert=true;
        vm.message='Le produit est bien enregistré !!!';
        vm.$Progress.finish()
       });
    },
find(){
    let vm=this
    vm.$Progress.start()
        axios.post('/api/produit/search',{
              label:vm.search,  
          }).then(response=>{
            console.log(response.data.data);
             vm.produits=response.data.data
             vm.$Progress.finish()
          }).catch(error=>{
              console.log(error);
          })
      },
//     serchBy(list,value){
// return list.filter(function(produit) {
//     return produit.label.toLowerCase().indexOf(value.toLowerCase()) > -1;
// });
//     },
    alertinit(){
        
        this.alert=false;
        this.message='';
    },
    exist(ref,categorie){
        var exist=false;
        this.produits.forEach(function(p){
            if ( p.categorie_id == categorie & p.ref.toLowerCase() === ref.toLowerCase()){
                 exist= true;          
            }
               
        });
        return exist;
    },
          //function to check if the product exist before or not
    fetchproduits(){
      axios.get('api/lproduits').then(response=>{
       this.lproduits=response.data.data
       console.log(response.data.data)
      });
    }

    },

    }
</script>