<template>
  <div>
    <router-link id="retPageButton" to="/cmd" class="btn btn-success" style="margin-top:20px">Retour</router-link>
    <button id="printPageButton" @click="print" class="btn btn-warning" style="margin-top:20px">Imprimer</button>
	<div id="">
      <div class="body">
    <header class="clearfix header">
      <div id="logo">
        <img v-bind:src="logo" style="width:200px">
      </div>
      <h1 class="h1" v-bind:style="{ backgroundImage: 'url(' + image + ')' }">FACTURE N°: {{cmds.num}}</h1>
      <div id="company" class="clearfix">
        <div>societe Zito        </div>
        <div>455 Foggy Heights,<br /> AZ 85004, Agadir</div>
        <div>(+212) 552057222</div>
        <div><a class="a" href="mailto:company@example.com">contact@zito.com</a></div>
      </div>
      <div id="project">
        <div style=""><span><b> CLIENT  :</b> </span> <b>{{client.prenom}}  {{client.nom}}</b>  </div>
        <div><span> <b>ADDRESSE  :</b></span> <b>{{client.adresse}} {{ville.ville}}</b>   </div>
        <div><span> <b>TELEPHONE  :</b></span> <b>0{{client.telephone}}</b> </div>
        <div v-if="client.email!=null"><span> <b>EMAIL   :</b></span> <a class="a" > <b>{{client.email}}</b> </a></div>
        <div><span> <b>DATE : </b></span> <b> {{cmds.created_at}} </b></div>
        
      </div>

    </header>
    <main>
            <table class="table">
        <thead>
          <tr>
            <th class="service">Reference</th>
            <th class="service">Designation</th>
            <th class="desc">Prix</th>
            <th>QUANTITE</th>
            <th>TVA(%)</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="c in cmds.produits">
            <td class="service"> {{c.ref}} </td>
            <td class="service"> {{c.design}} </td>
            <td class="desc"> {{c.prix_vente}} DHs</td>
            <td class="desc">  {{c.pivot.quantity }} </td>
            <td class="desc"> {{c.tva}} </td>
            <td class="desc"> {{(c.pivot.quantity*c.prix_vente) + ((c.pivot.quantity*c.prix_vente*c.tva)/100) }} DHs </td>
          </tr>
        </tbody>
      </table>
      <br>
    <div style="">
      <span style="font-size: 17px;font-style: initial;">TOTAL HT :</span>
      <span style="font-size: 17px;font-style: initial;"> {{cmds.totalHT}} MAD</span>
    </div>

    <div style="">
      <span style="font-size: 17px;font-style: initial;">TOTAL TTC :</span>
      <span style="font-size: 17px;font-style: initial;"> {{cmds.totalTTC}} MAD</span>
    </div>

    <div>
      <span style="font-size: 17px;font-style: initial;">TOTAL TTC :</span>
      <span style="font-size: 17px;font-style: initial;"> {{nbrlettre}} Dirhams</span>
    </div>


<br>
<br><br>
    </main>
</div>
  </div>
  </div>
</template>


<script>
 import jsPDF from 'jsPDF'
    function getletter(nbr){
        return NumberToLetter(nbr);
    }
  export default{
    data(){
      return {
        logo:'/Frame.png',
        image:'',
        cmds:[],
        client:{},
        ville:{},
        nbrlettre:'',
        showbtn:true
      }
    },
    methods : {
      
        
      getcmds(id){
        let vm=this;
        fetch('/api/lcmd/'+id)
            .then(function (res) {
                return res.json();
            })
            .then(function (data) {
                vm.cmds=data.data;
                vm.client=data.data.client
                vm.ville=data.data.client.ville
                console.log(data.data)
                vm.nbrlettre=getletter(vm.cmds.totalTTC)
            }).catch(function (err) {
                console.log(err)
            });
      },
      print(){
        this.showbtn=false;
       window.print();
      },

      },
      created(){
        this.getcmds(this.$route.params.id); 
        console.log(this.nbrlettre)
      }
  }
</script>



<style >
@media print {
  #printPageButton {
    display: none;
  }
  #retPageButton{
    display: none;
  }
}
  .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a.a {
  color: #5D6975;
  text-decoration: underline;
}

.body {
  position: relative;
  width: 25cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: Arial;
}

header.header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1.h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
}

#project {
  float: left;
}

#project span {
  color: #5D6975;

}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table.table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table.table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table.table th,
table.table td {
  text-align: center;
}

table.table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table.table .service,
table.table .desc {
}

table.table td {
  padding: 20px;
}

table.table td.service,
table.table td.desc {
  vertical-align: top;
}

table.table td.unit,
table.table td.qty,
table.table td.total {
  font-size: 1.2em;
}

table.table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer.footer {
  color: #5D6975;
  height: 30px;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  text-align: center;
  font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  font-size: 15px;
}

</style>

