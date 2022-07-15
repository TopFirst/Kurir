<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Seller;
use App\Models\Status;
use Prophecy\Call\Call;
use App\Models\Tblantar;
use App\Models\AppConfig;
use App\Models\Tbljemput;
use App\Models\Transaksi;
use App\Models\Tblantar_bk;
use Illuminate\Support\Str;
use App\Models\Tbljemput_bk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;
use Illuminate\Pagination\LengthAwarePaginator;

// use PDF;
class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:transaksi-list|transaksi-create|transaksi-edit|transaksi-delete', ['only' => ['index','show','transaksikurir','json']]);
         $this->middleware('permission:transaksi-create', ['only' => ['create','store','update']]);
         $this->middleware('permission:transaksi-edit', ['only' => ['edit','admin']]);
         $this->middleware('permission:transaksi-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skrg=$request->tanggalan?$request->tanggalan:date('Y-m-d');
        $penjual=$request->hp_seller??'';
        $status_id=$request->status_id??0;
        $kurir_id=Auth::user()->id;

        if(Auth::user()->hasRole('Admin'))
        {
            if(User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->exists())
                $kurir_id=$request->user_id??User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->first()->id;
        }

        // $display=collect([$kurir_id,$skrg,$penjual]);
        // $display->dd();

        return $this->kurir($kurir_id,$skrg,$penjual,$status_id);
    }
    /**
     * App config display.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function appconfig()
    {
        $app_configs=AppConfig::all();
        return view('transaksi.appconfig',compact('app_configs'))
        ->with('title','App Config');
    }
    /**
     * POST untuk ubah konfigurasi dari halama app config
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function ubahconfig(Request $request, $id)
    {
         request()->validate([
            'parameter_value' => 'required',
            'parameter_unit' => 'required',
        ]);

        $input = $request->all();
        $config = AppConfig::find($id);
        $config->update($input);

        return redirect()->route('transaksi.appconfig')
                        ->with('success','parameter berhasil diperbarui');
    }
    /**
     * Display a backup and restore page.
     *
     * @return \Illuminate\Http\Response
     */
    public function br()
    {
        $transaksis = Tbljemput_bk::latest()->paginate(10);
        return view('transaksi.br',compact('transaksis'))
        ->with('i', (request()->input('page', 1) - 1) * 10)
        ->with('title','Backup & Restore');
    }
        /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Tbljemput $transaksi)
    {
        return view('transaksi.show',compact('transaksi'))
        ->with('title','Detail Pengguna')
        ->with('url',url()->previous());

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Tbljemput $transaksi)
    {
        $kurirs=User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->get();
        $statuses=Status::all();

        return view('transaksi.edit',compact('transaksi','kurirs','statuses'))
        ->with('title','Edit Transaksi')
        ->with('url',url()->previous());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tbljemput $transaksi)
    {
         request()->validate([
            'talangan' => 'required',
            'tgl_jemput' => 'required',
            // 'tgl_antar' => 'required',
            'deskripsi' => 'required',
            'hp_seller' => 'required',
            'ongkir' => 'required',
            'url' => 'required',
        ]);
        $transaksi->update($request->all());
    
        if (request('user_id_antar'))
        {
            if(Tblantar::where('id',$transaksi->id)->exists())
            {
                $antar=Tblantar::find($transaksi->id);
                $antar->user_id=request('user_id_antar');
                $antar->created_at=request('tgl_antar');
                $antar->talangan=$transaksi->talangan;
                $antar->ongkir=$this->ongkir_bersih($transaksi->ongkir);
                if(request('id_status'))
                {
                    $antar->status_id=request('id_status');
                }
                $antar->save();
            }
            else
            {
                Tblantar::create([
                    'id'=>$transaksi->id,
                    'user_id'=>request('user_id_antar'),
                    'created_at'=>request('tgl_antar'),
                    'tbljemput_id'=>$transaksi->id,
                    'status_id'=>request('id_status')??1,
                    'talangan'=>$transaksi->talangan,
                    'ongkir'=>$this->ongkir_bersih($transaksi->ongkir)
                ]);
            }
        }
        return Redirect::to(request('url'))
                         ->with('success','transaksi berhasil diperbarui');

        // return redirect()->previous()
        //                 ->with('success','transaksi berhasil diperbarui');
    }
    /**
     * Backup transaksi, pindahkan data ke tabel backup
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function backup(Request $request)
    {
         request()->validate([
            'periode_backup' => 'required',
        ]);
        // set_time_limit(300);
        $jemput_range=explode(' - ',request('periode_backup'));
        $dari=date('Y-m-d',strtotime($jemput_range[0]));
        $ke=date('Y-m-d',strtotime($jemput_range[1]));
        
        // $collection=collect([$dari,$ke]);
        // $collection->dd();
        $jemputs = Tbljemput::whereDate('created_at','>',$dari)
        ->whereDate('created_at','<=',$ke)
        ->whereHas('antar',function($q){
            return $q->where('status_id',2);
        })->get();

        foreach($jemputs as $jemput)
        {
            Tbljemput_bk::create([
                'id'=>$jemput->id,
                'user_id'=>$jemput->user_id,
                'deskripsi'=>$jemput->deskripsi,
                'hp_seller'=>$jemput->hp_seller,
                'ongkir'=>$jemput->ongkir,
                'talangan'=>$jemput->talangan,
                'created_at'=>$jemput->created_at,
                'updated_at'=>$jemput->updated_at,
            ]);
            Tblantar_bk::create([
                'id'=>$jemput->antar->id,
                'tbljemput_id'=>$jemput->antar->tbljemput_id,
                'user_id'=>$jemput->antar->user_id,
                'ongkir'=>$jemput->antar->ongkir,
                'talangan'=>$jemput->antar->talangan,
                'status_id'=>$jemput->antar->status_id,
                'catatan'=>$jemput->antar->catatan,
                'created_at'=>$jemput->antar->created_at,
                'updated_at'=>$jemput->antar->updated_at,
            ]);
            $antar=Tblantar::find($jemput->id);
            $antar->delete();
            $jemput->delete();
        }
        return redirect()->route('transaksi.br')
                        ->with('success','transaksi berhasil di backup');
    }
    /**
     * Restore transaksi, pindahkan data dari tabel backup ke tabel utama
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
         request()->validate([
            'periode_restore' => 'required',
        ]);
        $jemput_range=explode(' - ',request('periode_restore'));
        $dari=date('Y-m-d',strtotime($jemput_range[0]));
        $ke=date('Y-m-d',strtotime($jemput_range[1]));
    
        $jemputs = Tbljemput_bk::whereDate('created_at','>',$dari)
        ->whereDate('created_at','<=',$ke)
        ->whereHas('antar',function($q){
            return $q->where('status_id',2);
        })->get();

        foreach($jemputs as $jemput)
        {
            Tbljemput::create([
                'id'=>$jemput->id,
                'user_id'=>$jemput->user_id,
                'deskripsi'=>$jemput->deskripsi,
                'hp_seller'=>$jemput->hp_seller,
                'ongkir'=>$jemput->ongkir,
                'talangan'=>$jemput->talangan,
                'created_at'=>$jemput->created_at,
                'updated_at'=>$jemput->updated_at,
            ]);
            Tblantar::create([
                'id'=>$jemput->antar->id,
                'tbljemput_id'=>$jemput->antar->tbljemput_id,
                'user_id'=>$jemput->antar->user_id,
                'ongkir'=>$jemput->antar->ongkir,
                'talangan'=>$jemput->antar->talangan,
                'status_id'=>$jemput->antar->status_id,
                'catatan'=>$jemput->antar->catatan,
                'created_at'=>$jemput->antar->created_at,
                'updated_at'=>$jemput->antar->updated_at,
            ]);
            $antar=Tblantar_bk::find($jemput->id);
            $antar->delete();
            $jemput->delete();
        }
        return redirect()->route('transaksi.br')
                        ->with('success','restore data berhasil');
    }

    /**
     * Display admin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        if(Auth::user()->hasRole('Admin'))
        {
            $statuses = Status::all();
            $sellers=Seller::all();
            $kurirs=User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->get();
            return view('transaksi.index',compact('statuses','kurirs','sellers'))
                ->with('i', (request()->input('page', 1) - 1) * 5)
                ->with('title', 'Transaksi');
        }
    }
    /**
     * Ambil data json untuk datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $jemput_range=explode(' - ',request('filter_periode'));
        
        // $dari=Carbon::parse(strtotime($jemput_range[0]))->toDateString().' 00:00:00';
        // $ke=Carbon::parse(strtotime($jemput_range[1]))->toDateString().' 23:59:59';
        $dari=date('Y-m-d',strtotime($jemput_range[0]));
        $ke=date('Y-m-d',strtotime($jemput_range[1]));

        $query = Tbljemput::with('kurir','antar','seller')->whereDate('created_at','>',$dari)->whereDate('created_at','<=',$ke)->orderBy('created_at','asc');

            if(request('filter_periode_antar')<>'')
            {
                $antar_range=explode(' - ',request('filter_periode_antar'));
                // $dari_antar=Carbon::parse(strtotime($antar_range[0]))->toDateString().' 00:00:00';
                // $ke_antar=Carbon::parse(strtotime($antar_range[1]))->toDateString().' 23:59:59';
                $dari_antar=date('Y-m-d',strtotime($antar_range[0]));
                $ke_antar=date('Y-m-d',strtotime($antar_range[1]));
    
                $query= $query->whereHas('antar',function($dat) use($dari_antar,$ke_antar){
                    return $dat->whereDate('created_at','>',$dari_antar)->whereDate('created_at','<=',$ke_antar); 
                });
            }
        $dat=$query->when(request('filter_kurir'),function($q){
                $kurir=request('filter_kurir');
                if(request('filter_kurir_tipe')==1)
                {
                    $dat=$q->where(function($dat) use($kurir){
                        return $dat->whereHas('antar',function($dat) use($kurir){
                            return $dat->where('user_id',$kurir);
                        })->orWhere('user_id',$kurir);
                    });
                }
                elseif(request('filter_kurir_tipe')==2) //jemput
                {
                    $dat=$q->where('user_id',$kurir);
                }
                elseif(request('filter_kurir_tipe')==3) //antar
                {
                    $dat=$q->whereHas('antar',function($dat) use($kurir){
                        return $dat->where('user_id',$kurir);
                    });
                }
                return $dat;
        })
        ->when(request('filter_seller'),function($q){
            return $q->where('hp_seller','like',request('filter_seller').'%');
        })
        ->when(request('filter_status'), function($q){
            $stt=request('filter_status');
            $q->whereHas('antar',function($q) use($stt){
                return $q->where('status_id',$stt);
            });
        })->get();

        $totaltalangan=$dat->sum('talangan');
        $totalongkir=$dat->sum('ongkir');
        $jmldata=$dat->count();

        $ongkirKurir=0;
        foreach($dat as $d)
        {
            $ongkirKurir += $this->ongkir_bersih($d['ongkir']);
        }

        $jemputan=$totaltalangan-$totalongkir;
        $ongkirBersih=$totalongkir-$ongkirKurir;
        // $antaran=$jemputan+($jmldata * 2);
        $antaran=$jemputan + $ongkirBersih;
        
        $grand_total=round($antaran-$jemputan,2);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){

            $btn = '<div class="row justify-content-between" style="width:80px;">
                <div class="form-group">
                <a href="https://wa.me/' . $row->hp_seller . '" target="_blank" class="text text-success"><i class="fa fa-phone"></i></a>
                <a href="'.route('transaksi.edit',$row->id).'" class="text text-info"><i class="fa fa-edit"></i></a>
                </div>
                <a href="#" class="text text-danger hapus" data-id="'. $row->id .'"><i class="fa fa-trash"></i></a>
                </div>';
            // <form action="'.route('transaksi.destroy',$row->id).'" method="POST">
            //     '. csrf_field() . method_field('DELETE').'
            //     <a href="'.route('transaksi.edit',$row->id).'" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>
            //     <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')"><i class="fa fa-trash"></i></button>
            // </form>';
            return $btn;
            })

            ->editColumn('id', function($row){
            $btn = '<a href="'.route('transaksi.show',$row->id).'">'.$row->id.'</a>';
            return $btn;
            })
            ->addColumn('kurirjemput', function($row){
            return $row->kurir->name;
            })
            ->addColumn('kurirantar', function($row){
            return $row->antar->kurir->name??'-';
            })
            ->addColumn('status', function($row){
            return $row->antar->status->name??'-';
            })
            ->addColumn('tglproses', function($row){
            return $row->antar->created_at??'-';
            })
            ->addColumn('seller', function($row){
            return $row->seller->nama??$row->hp_seller;
            })
            ->rawColumns(['action','id'])
            ->with('totaltalangan',$totaltalangan)
            ->with('totalongkir',$totalongkir)
            ->with('sisa',$jemputan)
            ->with('antaran',$antaran)
            ->with('grand_total',$grand_total)
            ->with('jumlahdata',$jmldata)
            ->make(true);
    }
    

    // Generate PDF
    public function cetakpdf() {
        // retreive all records from db
        $jemput_range=explode(' - ',request('filter_periode'));
        // $dari=Carbon::parse(strtotime($jemput_range[0]))->toDateString().' 00:00:00';
        // $ke=Carbon::parse(strtotime($jemput_range[1]))->toDateString().' 23:59:59';
        $dari=date('Y-m-d',strtotime($jemput_range[0]));
        $ke=date('Y-m-d',strtotime($jemput_range[1]));
        $periode_jemput=request('filter_periode');

        $query = Tbljemput::whereDate('created_at','>',$dari)->whereDate('created_at','<=',$ke)->orderBy('created_at','asc');

        $periode_antar=request('filter_periode_antar');
        if($periode_antar<>'')
        {
            $antar_range=explode(' - ',request('filter_periode_antar'));
            // $dari_antar=Carbon::parse(strtotime($antar_range[0]))->toDateString().' 00:00:00';
            // $ke_antar=Carbon::parse(strtotime($antar_range[1]))->toDateString().' 23:59:59';
            $dari_antar=date('Y-m-d',strtotime($antar_range[0]));
            $ke_antar=date('Y-m-d',strtotime($antar_range[1]));

            $query= $query->whereHas('antar',function($dat) use($dari_antar,$ke_antar){
                return $dat->whereDate('updated_at','>',$dari_antar)->whereDate('updated_at','<=',$ke_antar); 
            });
        }

        if(request('filter_kurir_tipe'))
            if(request('filter_kurir_tipe')==1)
                $tipe="Antar/Jemput";
            elseif(request('filter_kurir_tipe')==2)
                $tipe="Jemput";
            else
                $tipe="Antar";
        else
            $tipe='-';

        $kurir_pdf=User::find(request('filter_kurir'))->name??'-';
        $seller=request('filter_seller')??"-";
        $stt_pdf=Status::find(request('filter_status'))->name??'Semua';

        $dat=$query
        ->when(request('filter_kurir'),function($q){
                $kurir=request('filter_kurir');
                if(request('filter_kurir_tipe')==1)
                {
                    $dat=$q->where(function($dat) use($kurir){
                        return $dat->whereHas('antar',function($dat) use($kurir){
                            return $dat->where('user_id',$kurir);
                        })->orWhere('user_id',$kurir);
                    });
                }
                elseif(request('filter_kurir_tipe')==2) //jemput
                {
                    $dat=$q->where('user_id',$kurir);
                }
                elseif(request('filter_kurir_tipe')==3) //antar
                {
                    $dat=$q->whereHas('antar',function($dat) use($kurir){
                        return $dat->where('user_id',$kurir);
                    });
                }
                return $dat;
        })
        ->when(request('filter_seller'),function($q){
            return $q->where('hp_seller','like','%'.request('filter_seller').'%');
        })
        ->when(request('filter_status'), function($q){
            $stt=request('filter_status');
            $q->whereHas('antar',function($q) use($stt){
                return $q->where('status_id',$stt);
            });
        })->get();
  
        $totaltalangan=$dat->sum('talangan');
        $totalongkir=$dat->sum('ongkir');
        $total=$totaltalangan-$totalongkir;
        return view('transaksi.pdf',compact('dat'))
        ->with('jemput',$periode_jemput)
        ->with('antar',$periode_antar)
        ->with('tipe',$tipe)
        ->with('kurir',$kurir_pdf)
        ->with('hp_seller',$seller)
        ->with('status',$stt_pdf)
        ->with('total_talangan',$totaltalangan)
        ->with('total_ongkir',$totalongkir)
        ->with('grand_total',$total);
      }
        /**
     * Ambil data json untuk datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function cekseller()
    {
        if(request('hp_seller'))
            return Seller::where('hp',request('hp_seller'))->first()->id??0;
        return 0;
    }
    /**
     * Display a listing of the transaksi by kurir.
     *
     * @return \Illuminate\Http\Response
     */
    private function kurir(int $user_id, string $tanggalan, string $penjual, int $id_status)
    {
        $durasiCutoff = AppConfig::where('slug','cut-off-time')->first();
        $strDurasiCutOff="+".($durasiCutoff->parameter_value + 24)." hours";
        $newformat =Carbon::parse($tanggalan)->format('m/d/Y');
        $kemarin=date('Y-m-d 00:00:00',strtotime($tanggalan."-1 days"));
        $cuttofHariIni=date('Y-m-d H:i:s',strtotime($kemarin.$strDurasiCutOff));

                // $display=collect([$strDurasiCutOff,$newformat, $kemarin, $cuttofHariIni]);
                // $display->dd();

        $kurirs=User::whereHas("roles", function($q){ $q->where("name", "Kurir"); })->get();
        $statuses=Status::get();
        // $transaksis_antar = Tblantar::where('status_id',1)
        $transaksis_antar = Tblantar::with('kurir','status', 'jemput')->where(function($query) use($kemarin,$cuttofHariIni){
            $query->where(function($q) use($kemarin,$cuttofHariIni){
                $q->where('created_at','>',$kemarin)
                ->where('created_at','<',$cuttofHariIni);
            })
            ->orWhere('status_id',1);
        })
        ->where('user_id',$user_id)
        ->where('status_id','<>',3)
        ->when($id_status>0, function($q) use($id_status){
            return $q->where('status_id',$id_status);
        })
        ->orderBy('updated_at','desc')->get();

        $transaksis_belum_antar=Tbljemput::doesntHave('antar')->get();
        $transaksiProcess=Tbljemput::with('antar')->whereHas('antar', function($g){
            $g->where('status_id',1);
        })->orderBy('created_at','asc')->get();
        foreach($transaksiProcess as $tp)
        {
            $transaksis_belum_antar->push($tp);
        }

        //olah transaksi jemput
        $transaksis_jemput = Tbljemput::where('user_id',$user_id)
        ->whereDate('created_at',Carbon::parse($tanggalan)->format('Y-m-d'))
        ->when($penjual, function($q) use($penjual){
            return $q->where('hp_seller','like',$penjual.'%');
        })
        ->orderBy('created_at','asc')->get();

        //olah transaksi jemput yang cancel
        $transaksis_jemput_cancel=Tbljemput::with('antar')//where('user_id',$user_id)
        ->Where(function($query) use($user_id) {
            $query->where('user_id', $user_id)
                  ->orWhereHas('antar', function($g) use($user_id){
                    $g->where('user_id',$user_id);
                });
        })
        ->whereHas('antar', function($g){
            $g->where('status_id',3);
        })
        ->when($penjual, function($q) use($penjual){
            return $q->where('hp_seller','like',$penjual.'%');
        })
        ->orderBy('created_at','asc')->get();

        //ambil data seller untuk list pencarian
        $sellers=Seller::all();
        
        return view('transaksi.kurir',compact('transaksis_antar','transaksis_jemput','kurirs','transaksis_belum_antar','transaksis_jemput_cancel','statuses','sellers'))
        ->with('id_pengguna',$user_id)
        ->with('id_status',$id_status)
        ->with('tanggal',$newformat)
        ->with('hp',$penjual);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kurirs=User::all();
        $sellers=Seller::all();
        $weeknumber2=Carbon::now()->weekOfYear;
        $weeknumber=sprintf("%02d", $weeknumber2);
        $id_baru=Str::of(date('y'))->append($weeknumber)->append('-'. Auth::user()->id)->append('-'. $this->str_random());
        $ongkir_dasar = AppConfig::where('slug','default-ongkir')->first();
        while(Tbljemput::where('id',$id_baru)->exists())
        {
            $id_baru=Str::of(date('y'))->append(date('m'))->append('-'. $this->str_random());
        }
        return view('transaksi.create',compact('kurirs','sellers'))
        ->with('id_baru', $id_baru)
        ->with('ongkir_dasar', $ongkir_dasar->parameter_value);
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
     * fungsi untuk ngecek angkos kirim.
     *
     *
     * @param  int  $ongkos_kirim
     * @return int
     */
    function ongkir_bersih ($ongkir)
    {
        $jatah_owner = AppConfig::where('slug','pendapatan-owner')->first();
        // $display=collect([
        //     $jatah_owner->id,
        //     $jatah_owner->parameter_name,
        //     $jatah_owner->parameter_value,
        //     $jatah_owner->parameter_unit,
        // ]);
        // $display->dd();
        $ongkir_baru=0;
        $param_unit=$jatah_owner->parameter_unit;
        if($param_unit=="%")
        {
            $ongkir_baru= ((int)$ongkir)-(((int)$jatah_owner->parameter_value)/100*$ongkir);
        }
        elseif($param_unit=="Rb")
        {
            $ongkir_baru= (int)$ongkir;
            $ongkir_baru-= (int)$jatah_owner->parameter_value;
        }

        // $display=collect([
        //     $ongkir,
        //     $ongkir_baru,
        // ]);
        // $display->dd();
        
        return round($ongkir_baru, 2);
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
            'id'=>'required',
            // 'user_id' => 'required',
            'deskripsi' => 'required',
            'hp_seller' => 'required',
            'ongkir' => 'required',
            'talangan' => 'required',
        ]);
        $input = $request->all();
        if($input['ongkir']==0)
            $input['ongkir']=$input['custom_ongkir'];
        $input['user_id']=$request->user_id??Auth::user()->id;
        //simpan seller baru jika no belum tersimpan
        if(!Seller::where('hp',$request->hp_seller)->exists())
        {
            Seller::create(['hp'=>$request->hp_seller]);
        }
        //simapn data penjemputan
        Tbljemput::create($input);
    
        return redirect()->route('transaksi.index')
                        ->with('success','transaksi baru berhasil dibuat.');
    }
    /**
     * Store a newly created pengantaran dari tabel penjemputan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function konfirmasi_antar(Request $request)
    {
        request()->validate([
            'tbljemput_id'=>'required'
        ]);
        // $display=collect([$request->tbljemput_id]);
        // $display->dd();

        $jemput=Tbljemput::with('antar')->find($request->tbljemput_id);

        if($jemput->antar)
        {
            $antaran=Tblantar::find($jemput->id);
            $antaran->user_id=Auth::user()->id;
            $antaran->created_at=Carbon::now();
            $antaran->save();
            return redirect()->route('transaksi.index')
            ->with('success','transaksi kurir berhasil diganti');
        }
        else
        {
            Tblantar::create([
                'id'=>$jemput->id,
                'user_id'=>Auth::user()->id,
                'tbljemput_id'=>$jemput->id,
                'status_id'=>1,
                'talangan'=>$jemput->talangan,
                'ongkir'=> $this->ongkir_bersih($jemput->ongkir),
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now()

                // 'ongkir'=>($jemput->ongkir)-(0.2*$jemput->ongkir),
            ]);
            // return redirect()->route('transaksi.index')
        // return redirect()->back()->with('success','Transaksi berhasil dihapus');

            return redirect()->back()
            ->with('success','transaksi pengantaran baru terkonfimasi.');
        }

        // Tblantar::create($request->all());
    

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function gantistatus(Request $request)
    {
         request()->validate([
            'status_id' => 'required',
            'id' => 'required'
        ]);

        $antar=Tblantar::find($request->id);
        // if($request->status_id==3)//cancel
        // {
        //     $antar->user_id=Tbljemput::find($request->id)->user_id; //balikkan user ke yang jemput
        // }
        $antar->status_id=$request->status_id;
        $antar->catatan=$request->catatan??'';
        // $antar->created_at=Carbon::now();
        $antar->save();
    
        return redirect()->back()
                        ->with('success','Status transaksi berhasil diganti');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tbljemput $transaksi)
    {
        if(Tblantar::where('id',$transaksi->id)->exists())
        {
            $transaksiantar=Tblantar::find($transaksi->id);
            $transaksiantar->delete();
        }

        $transaksi->delete();
        // return redirect()->route($rute)
        //                 ->with('success','Transaksi deleted successfully');
        return redirect()->back()
        ->with('success','transaksi berhasil dihapus');
        // return redirect()->back()->with('success','Transaksi berhasil dihapus');
    }
    /**
     * hapus transaksi pakai json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function hapus(Request $request)
    {
        request()->validate([
            'id' => 'required',
        ]);
        $transaksi=Tbljemput::find(request('id'));

        if(Tblantar::where('id',$transaksi->id)->exists())
        {
            $transaksiantar=Tblantar::find($transaksi->id);
            $transaksiantar->delete();
        }

        $transaksi->delete();
        
        return response()->json(
            [
              'success' => true,
              'message' => "Transaksi berhasil dihapus",
            ]
       );
    }
    /*
    Get jemput detail untuk tampilan kurir pas pengantaran
    */
    public function GetJemput(Request $request)
    {
        request()->validate([
            'id' => 'required',
        ]);
        $transaksi=Tbljemput::find(request('id'));
        
        return response()->json(
            [
              'success' => true,
              'data' => $transaksi,
              'message' => "Load Transaksi berhasil",
            ]
       );
    }
}
