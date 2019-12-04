<template>
    <div style="margin-top:30px;">

     <div v-if="alert" class="alert alert-success alert-dismissible" role="alert">
       <center>{{message}}</center> 
  <button type="button" @click="alertinit" class="close" ><span aria-hidden="true">&times;</span></button>
  
</div>

 <div v-if="show" style="border:solid grey 1px;border-radius:4px;;padding:9px;width:50%;margin: auto;">

        <form @submit.prevent="saveclient">
          <div class="row">
          <div class="col">
            <label for="recipient-name" class="col-form-label">Nom :</label>
            <input type="text" class="form-control" id="recipient-name" required="" v-model="client.nom">
          </div>
          <div class="col">
            <label for="recipient-name" class="col-form-label">Prenom :</label>
            <input type="text" class="form-control" id="recipient-name" required v-model="client.prenom">
          </div>
          </div>
          <div class="row">
          <div class="col">
            <label for="message-text" class="col-form-label">Telephone(+212 ):</label>
            <input placeholder="666778899"  minlength="9" maxlength="9"  type="tel" class="form-control" required v-model="client.telephone">
          </div>
          <div class="col">
            <label for="message-text" class="col-form-label">Email :</label>
           <input type="text" class="form-control" id="recipient-name" v-model="client.email">
          </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Adresse :</label>

            <input type="text" class="form-control" id="recipient-name" required v-model="client.adresse">
          </div>
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Ville:</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01" v-model="client.ville_id">
                    <option v-for="c in villes" v-bind:value="c.id">{{c.ville}}</option>
                  </select>
                </div>
                <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="show=false">Close</button>
        <button v-if="showBtnU" v-on:click="updatedata" type="button" class="btn btn-warning " id="update">Update</button>
        <button v-if="showBtnS" type="submit" class="btn btn-primary" >Enregistrer</button>
      </div>
        </form>
        <div v-if="existp" class="alert alert-danger alert-dismissible" role="alert">
              <center>{{ message_err }}</center> 
            </div>
    </div>



        <button type="button" class="btn btn-info" v-on:click="show = true;showBtnU=false;showBtnS=true;client={}" style="margin-top:6px;">Ajouter un client</button>


    <div class="input-group mb-3" style="width:250px;margin-top:10px;">
  <div class="input-group-prepend">
<button class="btn btn-outline-info"  v-on:click="find" type="button"  id="button-addon1">chercher</button>
  </div>
  <input type="text"  class="form-control" v-model="search"  aria-label="Example text with button addon" aria-describedby="button-addon1">
</div>


<table class="table">
    <thead>
        <tr>
            <th>nom & prenom</th>
            <th>telephone</th>
            <th>email</th>
            <th>adresse</th>         
            <th>ville</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <tr   v-for="c in clients">
            <td>{{c.nom}} {{c.prenom}}</td>
            <td>{{c.telephone}}</td>
            <td v-if="c.email!=null">{{c.email}}</td>
            <td v-if="c.email==null">-</td>
            <td>{{c.adresse}}</td>
            <td>{{c.ville.ville}}</td>
            <td>
               <button type="button" v-on:click="editclick(c.id)" class="btn btn-success btn-sm"  >Edit</button>
                <button type="button" v-on:click="deleteclient(c.id)" class="btn btn-danger btn-sm" >Delete</button>
            </td>
        </tr>
    </tbody>
</table>
<nav aria-label="..." style="margin-left:50%;">
  <ul class="pagination">
    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
      <a class="page-link"  tabindex="-1" @click="fetchclient(pagination.prev_page_url)">Previous</a>
    </li>
<li class="disabled page-item text-dark"><a class="page-link" >Page : {{pagination.current_page}} of {{pagination.last_page}} </a></li>

    <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
      <a @click="fetchclient(pagination.next_page_url)" class="page-link" >Next</a>
    </li>
  </ul>
</nav>
</div>
</template>

<script>

export default {
    data(){
        return {

            lclients:[],
            clients: [],
            villes:[],
            edit:false,
            show:false, 
            showBtnU:false,
            search:'',
            alert:false,
            message:'',
            existp:false,
            message_err:'',
            showBtnS:true,
            pagination: {},
            client_id:0,
            client: {
                id: 0,
                nom: '',
                prenom: '',
                telephone:'',
                email:'',
                adresse:'',
                ville_id:0,
                ville:{}             

              }
            }

          },
    created(){
      this.$Progress.start()
      this.fetchclient();
      this.fetchville()
      this.fetchclients()
    },
    mounted(){
      this.$Progress.finish()
    },
    methods:{
         fetchclient(page_url){
          this.$Progress.start()
          let vm=this;
            page_url=page_url || '/api/clients';
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.clients=res.data;
                vm.makepagination(res.meta,res.links);
                vm.$Progress.finish()
            });
        },
        fetchville(){
                fetch('api/villes').then(res=>res.json()).then(res=>{
                this.villes=res
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
        saveclient() {
          console.log(this.client)
       var vm=this;
       vm.$Progress.start()
       if ((this.exist(this.client.nom,this.client.prenom,this.client.telephone)) ) {
        vm.$Progress.fail()
       this.message_err='le client existe déja !!!';
        this.existp=true;
       }
       else if(this.client.ville_id==null){
          alert("Insérer la ville ")
       }
       else{
        fetch('api/client',{
        method: 'post',
        body: JSON.stringify(this.client),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchclient();
        vm.alert=true;
        vm.client={}
        vm.message='Le client est bien enregistré !!!';
        vm.$Progress.finish()
       });
       }
       
    },


    find(){
      let vm=this
      vm.$Progress.start()
    
        axios.post('/api/client/search',{
              nom:vm.search,  
          }).then(response=>{
            console.log(response.data.data);
             vm.clients=response.data.data
             vm.$Progress.finish()
          }).catch(error=>{
              console.log(error);
              vm.$Progress.fail()
          })
      },

        deleteclient(id){
       let vm=this;
        if (confirm('vous etes sur ?!')) {
          vm.$Progress.start()
            fetch('api/client/'+id,{
                method:'delete'
            }
                ).then(res=>res.json()).then(data=>{
                    this.fetchclient();
                    vm.alert=true;
                    vm.message='Le categorie est bien supprimé !!!';
                    vm.$Progress.finish()
                });
            }
        },
        editclick(id){

        fetch('api/client/'+id).then(res=>res.json()).then(res=>{
                this.client=res.data;
            })
        this.show=true;
        this.showBtnU=true;
        this.showBtnS=false;
        //this.produit_id=id;
           
    },
    updatedata(){

        let upd={
            nom: this.client.nom,
            prenom: this.client.prenom,
            telephone: this.client.telephone,
            email:this.client.email,
            adresse:this.client.adresse,
            ville_id:this.client.ville_id
        };
       var vm=this;     
       vm.$Progress.start()    
       fetch('api/client/'+this.client.id,{
        method: 'put',
        body: JSON.stringify(upd),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchclient();
        vm.alert=true;
        vm.message='Le client est bien enregistré !!!';
        vm.$Progress.finish()
       });
    },
        alertinit(){
        this.alert=false;
        this.message='';
    },
        exist(nom,prenom,telephone){
        var exist=false;
        this.lclients.forEach(function(p){
            if ( p.nom.toLowerCase() === nom.toLowerCase() && p.prenom.toLowerCase() === prenom.toLowerCase() && p.telephone == telephone){
                 exist= true;          
            }
               
        });
        return exist;
    },
      //function to check if the client exist before or not
    fetchclients(){
      axios.get('api/lclients').then(response=>{
       this.lclients=response.data.data
      });
    }

    }
        }

</script>