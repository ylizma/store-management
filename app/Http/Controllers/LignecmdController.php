<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cmdpro;
use App\Lignecmd;
use App\Produit;
use App\Stock;
use App\Http\Requests;
use App\Http\Resources\Cmdpro as CmdproResource;
use App\Http\Resources\Lignecmd as LignecmdResource;

class LignecmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits= Lignecmd::orderBy('created_at', 'DESC')->with("produits","client")->paginate(15);
        // $produits= Lignecmd::orderBy('created_at', 'DESC')->with("procmds","client","procmds.products")->paginate(15);
         return LignecmdResource::collection($produits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $data = $req->json()->all(); 
        $ttc=0; 
        $ht=0; 
         $numC=Lignecmd::whereDate('created_at','=',date('Y-m-d'))->count()||0;
        $lc=new Lignecmd;
        $lc->totalTTC=0;
        $lc->totalHT=0;
        $lc->client_id=(int)$data["client_id"];
        if ($numC==0) {
            
        }
         $lc->num="N".($numC+1)."_".(date('d'))."Z".(date('m'))."".(substr(date('Y'), 2));

        $lc->save();
        foreach ($data["products"] as $k) {
        $s=Stock::where('produit_id','=',$k["label"]["id"])->firstOrFail();
        $prod=Produit::find($k["label"]["id"]);
        $s->current_q-=(int)$k["quantity"];
        $ttc+=((int)$k["quantity"]*$prod->prix_vente)+(((int)$k["quantity"]*$prod->prix_vente)*$prod->tva/100);
        $ht+=((int)$k["quantity"]*$prod->prix_vente);
        $lc->produits()->save($prod,['quantity' =>(int)$k["quantity"]]);
        $s->save();
        }
         $lc->totalTTC=$ttc;
         $lc->totalHT=$ht;
         $lc->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cmd=Lignecmd::with("client.ville","produits")->find($id);
        return new LignecmdResource($cmd);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cmd=Lignecmd::find($id);
        $cmd->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $value=$request->input('nom');
        $p=Lignecmd::orderBy('created_at', 'DESC')->with("produits","client")->whereHas('client', function ($query) use ($value){
        $query->where('nom', 'LIKE', '%'.$value.'%');
        $query->orWhere('prenom', 'LIKE', '%'.$value.'%');
    })->orWhere('num', 'LIKE', '%'.$value.'%')->get();

        return new LignecmdResource($p);
        // print($p);
        // die();
    }
}
