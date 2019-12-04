<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Requests;
use App\Http\Resources\Client as ClientResource;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits= Client::with("ville")->orderBy('created_at', 'DESC')->paginate(15);
        //return  response()->json($produits);
        return ClientResource::collection($produits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pro=new Client;
        $pro->nom=$request->input('nom');
        $pro->prenom=$request->input('prenom');
        $pro->telephone=$request->input('telephone');
        $pro->email=$request->input('email');
        $pro->adresse=$request->input('adresse');
         $pro->ville_id=$request->input('ville_id');
        $pro->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $pro=Client::findorfail($id);
        return new ClientResource($pro);
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
        $pro=Client::findOrfail($id);
        $pro->nom=$request->input('nom');
        $pro->prenom=$request->input('prenom');
        $pro->telephone=$request->input('telephone');
        $pro->email=$request->input('email');
        $pro->adresse=$request->input('adresse');
        $pro->ville_id=$request->input('ville_id');
        $pro->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro=Client::findorfail($id);
        $pro->delete();
        return $pro;
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
        $p=Client::with("ville")->where('nom', 'LIKE', '%'.$value.'%')->orWhere('prenom', 'LIKE', '%'.$value.'%')->get();
        return ClientResource::collection($p);
        // print($p);
        // die();
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getall()
    {
        $produits= Client::orderBy('created_at', 'DESC')->get();
        //return  response()->json($produits);
        return ClientResource::collection($produits);
    }
}
