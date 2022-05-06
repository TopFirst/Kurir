<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Exports\SellerExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class SellerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers=DB::table('sellers')
        ->select('sellers.*', DB::raw('(SELECT count(*) FROM tbljemputs WHERE tbljemputs.hp_seller = sellers.hp) as jumlah'))
        ->orderBydesc('jumlah')
        ->get();
        //$sellers = Seller::all();//->paginate(5);
        // $sellers->dd();
        return view('sellers.index',compact('sellers'))
        ->with('title','Seller');
    }
    /**
     * Export semua seller
     *
     * @return \Illuminate\Http\Response
     */
    public function exportseller()
    {
        return Excel::download(new SellerExport,'seller.xlsx');
    }
    
        
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'hp' => 'required',
        ]);
    
        Seller::create($request->all());
    
        return redirect()->route('seller.index')
                        ->with('success','seller baru berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::find($id);
        return view('sellers.edit',compact('seller'))
        ->with('title', 'Edit Seller');
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
        $this->validate($request, [
            'hp' => 'required',
        ]);
        $input = $request->all();
        $seller = Seller::find($id);
        $seller->update($input);
    
        return redirect()->route('seller.index')
                        ->with('success','seller berhasil diperbarui');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();
    
        return redirect()->route('seller.index')
                        ->with('success','seller berhasil dihapus');
    }
}
