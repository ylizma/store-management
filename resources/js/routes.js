import Vue from 'vue';
import VueRouter from 'vue-router';
import Client from '@/js/components/Clients';
import Produit from '@/js/components/Produits';
import Categorie from '@/js/components/Categorie';
import Cmd from '@/js/components/Cmd';
import Facteur from '@/js/components/Facture';
import Login from '@/js/components/Login';
import Stock from '@/js/components/Stock';
import Home from '@/js/components/Home';


Vue.use(VueRouter);

const router=new VueRouter({

	mode:'history',
	routes:[
	{
		path:'/produit',
		name:'produit',
		component:Produit,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/',
		name:'home',
		component:Produit,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/client',
		name:'client',
		component:Client,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/cmd',
		name:'commande',
		component:Cmd,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/cat',
		name:'Categorie',
		component:Categorie,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/fact/:id',
		name:'facteur',
		component:Facteur,
		meta:{
			requiresAuth:true,
		}
	},
	{
		path:'/login',
		name:'login',
		component:Login,
		meta:{
			requiresVisitor:true
		}
	},
		{
		path:'/stock',
		name:'stock',
		component:Stock,
		meta:{
			requiresAuth:true,
		}
	},
	]
});  

export default router;