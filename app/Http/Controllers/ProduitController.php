<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produit;
use App\Categorie;
use App\Stock;
use App\Http\Requests;
use App\Http\Resources\Produit as ProduitResource;
class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$produits= Produit::find(1)->categorie;
        $produits= Produit::orderBy('created_at', 'DESC')->with("stock","categorie")->paginate(15);
        //return  response()->json($produits);
        return ProduitResource::collection($produits);
        //return $produits;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pro=new Produit;
        $st=new Stock;
        //$pro->id=$request->input('id');
        $pro->ref=$request->input('ref');
        $pro->design=$request->input('design');
        $pro->prix_vente=$request->input('prix_vente');
        $pro->tva=$request->input('tva');
        $pro->quantity=$request->input('quantity');
         $st->current_q=$request->input('quantity');
         $st->total=$request->input('quantity');
        // 
         $cat=Categorie::find((int)$request->input('categorie_id'));
         $cat->produits()->save($pro);
         $st->produit_id=$pro->id;
         $st->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pro=Produit::with("categorie")->findorfail($id);
        return new ProduitResource($pro);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro=Produit::findorfail($id);
        $pro->delete();
        return new ProduitResource($pro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
         $pro=Produit::findOrfail($id);
        $pro->ref=$request->input('ref');
        $pro->design=$request->input('design');
        $pro->prix_vente=$request->input('prix_vente');
        $pro->tva=$request->input('tva');
        $pro->quantity=$request->input('quantity');
        $pro->categorie_id=$request->input('categorie_id');
        $pro->save();
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $value=$request->input('label');
        $p=Produit::with("categorie","stock")->where('design', 'LIKE', '%'.$value.'%')->orWhere('ref', 'LIKE', '%'.$value.'%')->get();
        return ProduitResource::collection($p);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getall()
    {
        //$produits= Produit::find(1)->categorie;
        $produits= Produit::orderBy('created_at', 'DESC')->get();
        //return  response()->json($produits);
        return ProduitResource::collection($produits);
        //return $produits;
    }

    public function addquantity(Request $request){
        $id=$request->input('id');
         $nbr=$request->input('nbr');
        $st=Stock::where("produit_id","=",$id)->firstOrFail();
        $st->total+=$nbr;
        $st->current_q+=$nbr;
        $st->save();
    }
    
}
