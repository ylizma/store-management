<template>
    <div style="margin-top:30px;">   


     <div v-if="alert" class="alert alert-success alert-dismissible" role="alert">
       <center>{{message}}</center> 
  <button type="button" @click="alertinit" class="close" ><span aria-hidden="true">&times;</span></button>
  
</div>

        <div v-if="show" style="border:solid grey 1px;border-radius:4px;padding:9px;width:50%;margin: auto;">
        
        <form @submit.prevent="savecategorie" class="color">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Label :</label>
            <input type="text" class="form-control" required id="recipient-name" v-model="categorie.label">
          </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" v-on:click="show=false">Close</button>

        <button v-if="showBtnU" v-on:click="updatedata" type="button" class="btn btn-warning " id="update">Update</button>
        <button v-if="showBtnS" type="submit" class="btn btn-primary" id="save">Enregistrer</button>
      </div>
        </form>

        </div>
 <button type="button" class="btn btn-info" v-on:click="show = true;showBtnU=false;showBtnS=true;" style="margin-top:6px;">Ajouter une categorie</button>
     <input type="text" class="form-control" placeholder="Enter a name"  style="width:250px;margin-top:10px;">
       
   <br/>
<table class="table table-striped">
    <thead> 
        <tr>
            
            <th>Label</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="c in categories" >
            
            <td>{{c.label}}</td>
            <td>
                <button type="button" v-on:click="editclick(c.id)" class="btn btn-success btn-sm"  >Edit</button>
                <button type="button" v-on:click="deletecategorie(c.id)" class="btn btn-danger btn-sm" >Delete</button>
            </td>
        </tr>
    </tbody>
</table>
<td>
  
</td>
</div>

</template>


<script>

export default {
    data(){
        return {

            categories: [],
            edit:false,
            show:false, 
            alert:false,
            message:'',
            showBtnU:false,
            showBtnS:true,
            pagination: {},
            
            categorie: {
                id: 0,
                label: ''            
      },

        }
    },
    created(){
        this.$Progress.start()
        this.fetchCategories();
    },
    mounted(){
        this.$Progress.finish()
    },
    methods:{
        fetchCategories(){
            fetch('api/categories').then(res=>res.json()).then(res=>{
                this.categories=res.data;           
            })
        },

        savecategorie() {
      var vm=this;
      vm.$Progress.start()
       fetch('api/categorie',{
        method: 'post',
        body: JSON.stringify(this.categorie),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchCategories();
        vm.alert=true;
        vm.message='Le categorie est bien enregistré !!!';
        vm.$Progress.finish()
        this.categorie={}
       });
    },
    deletecategorie(id){
       let vm=this;
       vm.$Progress.start()
        if (confirm('vous etes sur ?!')) {
            fetch('api/categorie/'+id,{
                method:'delete'
            }
                ).then(res=>res.json()).then(data=>{
                    this.fetchCategories();
                    vm.alert=true;
                     vm.message='Le categorie est bien supprimé !!!';
                     vm.$Progress.finish()
                });
            }
        },
        editclick(id){
        fetch('api/categorie/'+id).then(res=>res.json()).then(res=>{
                this.categorie=res.data;
            })
        
        this.showBtnU=true;
        this.showBtnS=false;
        this.show=true;
        //this.produit_id=id;
           
    },
    updatedata(){

        let upd={
            categorie_id:this.categorie.id,
            label: this.categorie.label
        };

       var vm=this;         
       vm.$Progress.start()
       fetch('api/categorie/'+this.categorie.id,{
        method: 'put',
        body: JSON.stringify(upd),
        headers:{
            'content-type': 'application/json'
        }
       }).then(data => {
        this.show=false;
        vm.fetchCategories();
        vm.alert=true;
        vm.message='Le categorie est bien enregistré !!!';
        vm.$Progress.finish()
       });
    },
        alertinit(){
        
        this.alert=false;
        this.message='';
    }
    }

}
</script>