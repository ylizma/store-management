<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use App\Http\Requests;
use App\Http\Resources\Categorie as CategorieResource;
class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits= Categorie::paginate(15);
        return CategorieResource::collection($produits);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat=new Categorie;
        $cat->id=$request->input('categorie_id');
        $cat->label=$request->input('label');
        $cat->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pro=Categorie::with("produits")->find($id);
        return new CategorieResource($pro);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro=Categorie::findorfail($id);
        $pro->delete();
        return new CategorieResource($pro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
         $pro=Categorie::findOrfail($id);
         $pro->label=$request->input('label');
        $pro->save();
    }
}
