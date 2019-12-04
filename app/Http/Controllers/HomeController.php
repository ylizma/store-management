<?php

namespace App\Http\Controllers;
use App\Cmdpro;
use App\Lignecmd;
use App\Produit;
use App\Stock;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // print_r('rr');
        $client=DB::table('clients')->count();
        $produit=DB::table('produits')->count();
        $cmd=DB::table('lignecmds')->count();
        $produitCategorie=DB::select('select count(p.id) as nbr,c.label as cat from produits p,categories c group by c.label ');
        $cmdpermonth=DB::select('select count(l.id) as nbr,Date(l.created_at) as month from lignecmds l group by Date(l.created_at) limit 10');
        $cmdperproduct=DB::select('select count(c.produit_id) as nbr,p.design as pro from lignecmd_produit c,produits p where c.produit_id=p.id group by p.design');
        return response()->json([
            'client' => $cmd,
            'produit'   => $produit,
            'cmd'   => $produit,
            'procat' => $produitCategorie,
            'cmdmonth' => $cmdpermonth,
            'cmdpro' =>$cmdperproduct
        ]);

    }

   
}
