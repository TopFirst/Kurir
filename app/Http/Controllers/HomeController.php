<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Seller;
use App\Models\Tblantar;
use App\Models\Tbljemput;
use App\Models\Transaksi;
use App\Models\AppConfig;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Exceptions\NotFound;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kurirs=User::all();
        if(Auth::user()->hasRole('Kurir'))
        {
        $weeknumber2=Carbon::now()->weekOfYear;
        $weeknumber=sprintf("%02d", $weeknumber2);
        $ongkir_dasar = AppConfig::where('slug','default-ongkir')->first();

        $id_baru=Str::of(date('y'))->append($weeknumber)->append('-'. Auth::user()->id)->append('-'. $this->str_random());
            while(Tbljemput::where('id',$id_baru)->exists())
            {
                $id_baru=Str::of(date('y'))->append(date('m'))->append('-'. $this->str_random());
            }
            $sellers=Seller::all();
            return view('transaksi/create',compact('kurirs'))
            ->with('title', 'Kurir')
            ->with('id_baru', $id_baru)
            ->with('ongkir_dasar', $ongkir_dasar->parameter_value);
        }
        elseif(Auth::user()->hasRole('Admin'))
        {
            // $jemputs = Tbljemput::latest()->take(5)->get();

            $kurirs=User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->get();
            $total_kurir=$kurirs->count();

            $sellers=DB::table('sellers')
            ->select('sellers.*', DB::raw('(SELECT count(*) FROM tbljemputs WHERE tbljemputs.hp_seller = sellers.hp) as jumlah'))
            ->orderBydesc('jumlah')
            ->take(4)->get();

            $kurirs=$kurirs->sortByDesc(function($query){
                return $query->jemputan->count();
            });


            $total_jemput=Tbljemput::without('kurir','seller','antar')->count();
            $total_antar=Tblantar::without('kurir','status', 'jemput')->count();
            
            $total_seller=Seller::count();
            return view('db',compact('kurirs','sellers'))
            ->with('total_jemput', $total_jemput)
            ->with('total_antar', $total_antar)
            ->with('total_kurir', $total_kurir)
            ->with('total_seller', $total_seller)
            ->with('title', 'Home');
        }
        else{
            return redirect()->route('web.index');
        }
    }
    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    function str_random($length = 4)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cekresi()
    {
        if(request('txtcari'))
        {
            if(Tbljemput::where('id',request('txtcari'))->exists())
            {
                $dat=Tbljemput::find(request('txtcari'));
                return view('transaksi/cekresi',compact('dat'));
            }
            else
                return redirect('/');
        }
        return redirect('/');
    }
    /**
     * Ambil data json untuk data yang belum diantar.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        // return Datatables::of(Tbljemput::all())->make(true);
        $data=Tbljemput::with('kurir')->doesntHave('antar')
        // ->orWhereHas("antar", function($q){ $q->where("status_id", 3); })
        ->get();

        // $totalbeluminput=Tbljemput::doesntHave('antar')->count();
        // $totalcancel=Tbljemput::WhereHas("antar", function($q){ $q->where("status_id", 3); })->count();

        $totaljemput=Tbljemput::without('kurir','seller','antar')->count();
        $totalantar=Tblantar::without('kurir','status', 'jemput')->count();
        $paket_onprocess=Tblantar::where("status_id", 1)->sum('talangan');
        $jml_paket_onprocess=Tblantar::where("status_id", 1)->count();


            return Datatables::of($data)
                    ->addIndexColumn()

                    ->editColumn('id', function($row){
                        //$btn = '<a href="'.route('transaksi.show',$row->id).'">'.$row->id.'</a>';
                        $btn = '<div class="row justify-content-between" style="width:80px;">
                            <a href="'.route('transaksi.show',$row->id).'">'.$row->id.'</a>
                            <div>
                            <a href="'.route('transaksi.edit',$row->id).'" class="text text-info"><i class="fa fa-edit"></i></a>
                            <a href="#" class="text text-danger hapus" data-id="'. $row->id .'"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>';
                           return $btn;
                    })
                    ->addColumn('kurirjemput', function($row){
                            return $row->kurir->name??'-';
                    })
                    ->addColumn('seller', function($row){
                            return $row->seller->nama??$row->hp_seller;
                    })
                    ->addColumn('status', function($row){
                        return '<span class="badge badge-warning">Belum Input</span>';
                    })
                    ->rawColumns(['id','status'])
                    ->with('totaljemput',$totaljemput)
                    ->with('totalantar',$totalantar)
                    ->with('paket_onprocess',$paket_onprocess)
                    ->with('jml_paket_onprocess',$jml_paket_onprocess)
                    ->make(true);
    }
    /**
     * Ambil data json untuk data yang cancel.
     *
     * @return \Illuminate\Http\Response
     */
    public function json_cancel()
    {
        $data=Tbljemput::with('kurir','antar')->WhereHas("antar", function($q){ $q->where("status_id", 3); })->get();
            return Datatables::of($data)
                    ->addIndexColumn()

                    ->editColumn('id', function($row){
                        //$btn = '<a href="'.route('transaksi.show',$row->id).'">'.$row->id.'</a>';
                        $btn = '<div class="row justify-content-between" style="width:80px;">
                            <a href="'.route('transaksi.show',$row->id).'">'.$row->id.'</a>
                            <div>
                            <a href="'.route('transaksi.edit',$row->id).'" class="text text-info"><i class="fa fa-edit"></i></a>
                            <a href="#" class="text text-danger hapus" data-id="'. $row->id .'"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>';
                           return $btn;
                    })
                    ->addColumn('kurirjemput', function($row){
                            return $row->kurir->name??'-';
                    })
                    ->addColumn('seller', function($row){
                            return $row->seller->nama??$row->hp_seller;
                    })
                    ->addColumn('status', function($row){
                        $stt='<span class="badge badge-warning">Belum Input</span>';
                        if(isset($row->antar))
                        {
                            if($row->antar->status->id==3)
                                $stt='<span class="badge badge-danger">'.$row->antar->status->name.'</span>';
                            else
                                $stt='<span class="badge badge-info">'.$row->antar->status->name.'</span>';
                        }
                            return $stt;
                            // return $row->antar->status->name??'-';
                    })
                    ->rawColumns(['id','status'])
                    ->make(true);
    }
    /**
     * Dokumentasi.
     *
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function dokumentasi()
    {
        $dokumentasis=Dokumentasi::all();
        return view('home.dokumentasi',compact('dokumentasis'))
        ->with('title','Dokumentasi');
    }

}
