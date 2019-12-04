<template>
	    <div style="margin-top:30px;">  
     <div v-if="alert" class="alert alert-success alert-dismissible" role="alert">
       <center>{{message}}</center> 
  <button type="button" @click="alertinit" class="close" ><span aria-hidden="true">&times;</span></button>
</div>
 
     <div class="input-group mb-3" style="width:250px;margin-top:10px;">
  <div class="input-group-prepend">
<button class="btn btn-outline-info"  v-on:click="find" type="button"  id="button-addon1">chercher</button>
  </div>
  <input type="text"  class="form-control" v-model="search"  aria-label="Example text with button addon" aria-describedby="button-addon1">
</div>

<br>
<table class="table ">
    <thead> 
        <tr>
          	<th>Réference</th>
            <th>Désignation</th>
            <th>categorie</th>
            <th>Stock Actuel</th>
            <th>Total Stock</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for=" p in produits" >
            
            	<td> {{p.ref}} </td>
             	<td>{{p.design}} </td>
             	<td>{{p.categorie.label}} </td>
              	<td>{{p.stock.current_q}} </td>
               	<td>{{p.stock.total}} </td>
                
            <td>

  <input type="number" class="form-control" @input="handleInput($event.target.value)" style="width:100px;margin-right:4px;display:inline-block" value="0">
  <button type="button" v-on:click="addquantity(p.id)" class="btn btn-info btn-sm" >Ajouter</button>

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
	export default{
		data(){
			return {
				produits:[],
				pagination: {},
				alert:false,
				quantity:0,
				message:'',
				search:''
			}
		},
		created(){
        this.$Progress.start()
        this.fetchProduits();

		},
		mounted(){
		this.$Progress.finish()
		},
		methods:{
			 fetchProduits(page_url){
            let vm=this;
            vm.$Progress.start()
            page_url=page_url || '/api/produits';
            fetch(page_url).then(res=>res.json()).then(res=>{
                this.produits=res.data;
                console.log(this.produits)
                vm.makepagination(res.meta,res.links);
                vm.$Progress.finish()
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

    addquantity(idd){
    	let vm=this
    vm.$Progress.start()
        axios.post('/api/produit/add',{ 
        	id:idd,
        	nbr:this.quantity
          }).then(response=>{
             this.fetchProduits()
             vm.$Progress.finish()
             vm.alert=true
             this.message="Les données sont bien enregistré"
          }).catch(error=>{
              console.log(error);
          })
    console.log(this.handleInput())
		},
		 alertinit(){
        this.alert=false;
        this.message='';
    },
		handleInput(value){
			this.quantity=value
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
    }
	}
</script>