<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use App\Models\User;
use App\Models\Seller;
use App\Models\Tbljemput;
use App\Models\web_about;
use App\Models\web_layanan;
use Illuminate\Http\Request;
use App\Models\web_general_info;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-edit', ['only' => ['edit','update_gen_info_pic']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $web_data=web_general_info::first();
        $web_layanans=web_layanan::where('tipe','layanan')->get();
        $web_top_info=web_layanan::where('tipe','top_info')->first();
        $web_galleries=web_layanan::where('tipe','gallery')->get();
        $web_client=web_layanan::where('tipe','client')->get();
        $web_testimoni=web_layanan::where('tipe','testimoni')->get();
        $web_testimoni_head=web_layanan::where('tipe','testimoni_head')->first();
        $web_contact=web_layanan::where('tipe','contact')->first();
        $web_about=web_layanan::where('tipe','about')->first();

        // $web_about=web_about::first();

        return view('index',
        compact('web_data','web_layanans','web_about',
        'web_galleries','web_client','web_testimoni','web_testimoni_head',
        'web_contact','web_top_info'))
        ->with('total_kurir', User::all()->count())
        ->with('total_transaksi', Tbljemput::all()->count())
        ->with('total_pelanggan', Seller::all()->count());

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update_gen_info_pic(Request $request, web_general_info $web_general_info)
    {
  
        if ($request->hasFile('url_mainpic')) {
            //  Let's do everything here
            if ($request->file('url_mainpic')->isValid()) {
                $validated = $request->validate([
                    'url_mainpic' => 'mimes:jpeg,jpg,png|max:1014',
                ]);
                //$extension = $request->url_mainpic->extension();
                $filename = $request->file('url_mainpic')->getClientOriginalName();
                // $display=collect([$web_general_info->id,$filename]);
                // $display->dd();

                // $filename="aoksinergi";
                // $extension="jpg";
                // $request->file('url_mainpic')->storeAs('/public/images', $filename);
                Storage::disk('uploads')->put($filename, file_get_contents($request->file('url_mainpic')));
                //$url = Storage::url($filename);
                
                $web_general_info->update(['url_mainpic'=>'uploads/'.$filename],['id'=>$web_general_info->id]);

                Session::flash('success', "Success!");
                // return \Redirect::back();
                return redirect()->route('web.index')
                ->with('success','web sudah diperbarui');
            }
        }
        abort(500, 'Could not upload image :(');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update_layanan(Request $request)
    {
        request()->validate([
        'nama' => 'required',
        'tipe' => 'required',
        'id' => 'required',
        // 'desc' => 'required',
        ]);

        if ($request->hasFile('url_logo')) {
        // Let's do everything here
        if ($request->file('url_logo')->isValid()) {
        $validated = $request->validate([
        'url_logo' => 'mimes:jpeg,jpg,png,svg|max:1014',
        ]);

        $name = $request->file('url_logo')->getClientOriginalName();
        Storage::disk('uploads')->put($name, file_get_contents($request->file('url_logo')));

        // $request->file('url_logo')->storeAs('public/images',$name);
        //Storage::disk('public')->put('images/'.$name,$request->file('url_logo'));

        $databaru=web_layanan::find($request->id);
        $databaru->nama=$request->nama;
        $databaru->sub_judul=$request->sub_judul;
        $databaru->tipe=$request->tipe;
        $databaru->url_logo='uploads/'.$name;
        $databaru->desc=$request->desc;
        $databaru->save();

        }
        }
        else
        {
        $databaru=web_layanan::find($request->id);
        $databaru->nama=$request->nama;
        $databaru->sub_judul=$request->sub_judul;
        $databaru->tipe=$request->tipe;
        $databaru->desc=$request->desc;
        $databaru->save();
        }

        return redirect()->route('web.index')
                        ->with('success','Data berhasil diperbarui');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update_web_info(Request $request, web_general_info $web_general_info)
    {
        request()->validate([
        'nama' => 'required',
        'hp1' => 'required',
        'hp2' => 'required',
        'email1' => 'required',
        'email2' => 'required',
        'alamat1' => 'required',
        'alamat2' => 'required',
        'fb' => 'required',
        'twitter' => 'required',
        'ig' => 'required',
        'yt' => 'required',
        ]);

        // $uu=$request->collect();
        // $uu->dd();
        if ($request->hasFile('url_logo')) 
        {
            if ($request->file('url_logo')->isValid()) 
            {
                $validated = $request->validate([
                'url_logo' => 'mimes:jpeg,jpg,png,svg|max:1014',
                ]);

                $name = $request->file('url_logo')->getClientOriginalName();
                // $request->file('url_logo')->storeAs('public/images',$name);
                Storage::disk('uploads')->put($name, file_get_contents($request->file('url_logo')));

                $databaru=web_general_info::find($web_general_info->id);
                $databaru->nama=$request->nama;
                $databaru->url_logo='uploads/'.$name;
                $databaru->hp1=$request->hp1;
                $databaru->hp2=$request->hp2;
                $databaru->email1=$request->email1;
                $databaru->email2=$request->email2;
                $databaru->alamat1=$request->alamat1;
                $databaru->alamat2=$request->alamat2;
                $databaru->fb=$request->fb;
                $databaru->twitter=$request->twitter;
                $databaru->ig=$request->ig;
                $databaru->yt=$request->yt;
                $databaru->save();

            }
        }
        else
        {
            $databaru=web_general_info::find($web_general_info->id);
            // $databaru->dd();
            $databaru->nama=$request->nama;
            $databaru->hp1=$request->hp1;
            $databaru->hp2=$request->hp2;
            $databaru->email1=$request->email1;
            $databaru->email2=$request->email2;
            $databaru->alamat1=$request->alamat1;
            $databaru->alamat2=$request->alamat2;
            $databaru->fb=$request->fb;
            $databaru->twitter=$request->twitter;
            $databaru->ig=$request->ig;
            $databaru->yt=$request->yt;
            $databaru->save();
        }

        return redirect()->route('web.index')
                        ->with('success','Data berhasil diperbarui');
    }

    /**
     * Store a newly gallery image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function isi_layanan(Request $request)
    {
        request()->validate([
            'nama' => 'required',
            'url_logo' => 'required',
            'tipe' => 'required'
        ]);
        if ($request->hasFile('url_logo')) {
            //  Let's do everything here
            if ($request->file('url_logo')->isValid()) {
                $validated = $request->validate([
                    'url_logo' => 'mimes:jpeg,jpg,png,svg|max:1014',
                ]);
                $name = $request->file('url_logo')->getClientOriginalName();
                // $request->file('url_logo')->storeAs('public/images',$name);
                Storage::disk('uploads')->put($name, file_get_contents($request->file('url_logo')));

                $gambarbaru=new web_layanan;
                $gambarbaru->nama=$request->nama;
                $gambarbaru->sub_judul=$request->sub_judul;
                $gambarbaru->url_logo='uploads/'.$name;
                $gambarbaru->tipe=$request->tipe;
                $gambarbaru->desc=$request->desc;
                $gambarbaru->save();
                // web_layanan::create($request->all());
            }
        }
    
        return redirect()->route('web.index')
                        ->with('success','Isi gallery berhasil.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function hapus(Request $request)
    {
        request()->validate([
            'id' => 'required',
        ]);
        $layan=web_layanan::find($request->id);
        // if(Storage::disk('s3')->exists($layanan->url_logo))
        // {
        //     Storage::delete($layanan->url_logo);
        // }
        $layan->delete();
    
        return redirect()->route('web.index')
                        ->with('success','Product deleted successfully');
    }
}
