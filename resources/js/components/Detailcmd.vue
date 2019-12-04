<template>
	<div style="margin-top:30px;">
		 <div  style="border:solid grey 1px;border-radius:4px;padding:9px;">
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Client :</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01" required="" >
                    <option selected>Choose...</option>
                    <option v-for="cl in clients" v-bind:value="cl.id">{{cl.nom }} {{cl.prenom }}</option>
                  </select>
          </div>
          <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Produit :</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01"  required>
                    <option selected>Choose...</option>
                    <option></option>
                  </select>
          </div>
                    <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Quantite :</label>
                  </div>
                <input type="number" class="form-control" id="recipient-name" required >        
                <button  type="button" style="margin-left:3px;" class="btn btn-success btn-sm" >Ajouter produit</button>

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
      <tr v-for="v in sproduits">
        <td></td>
        <td></td>
        <td>
          <button  type="button"  style="margin-left:3px;" class="btn btn-danger btn-sm" >Delete</button>
        </td>
      </tr> 
    </tbody>
  </table>
      

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" >Close</button>
        <button  type="button" class="btn btn-warning " id="update">Imprimer</button>
        <button  type="submit" class="btn btn-primary" >Enregistrer </button>
      </div>
    </div>
	</div>
</template>

<script>
		export default{
      props: ['lcmdid'],
		data(){
			return {
				cmds:[],
        client:{},
        produits:[],
        clients:[],
        produit:{
          label:'',
          quantity:''
          
        },
        sproduits:[] 
			}
		},
    created(){
      this.fetchcmd(this.lcmdid);
      this.fetchinfos();
    },  
    methods:{
      fetchcmd(id){
      let vm=this;
            var page_url='/api/lcmd/'+id;
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.cmds=res.data;
                this.client=this.cmds.client;
                this.sproduits=this.cmds.produit_id;           
            });
    },
        fetchinfos(){
      fetch('api/produits').then(res=>res.json()).then(res=>{
                this.produits=res.data;
            });
      fetch('api/clients').then(res=>res.json()).then(res=>{
                this.clients=res.data;
            });
    },
    }
	}
</script>