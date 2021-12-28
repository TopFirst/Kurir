<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:transaksi-create', ['only' => ['changepassword','viewchangepassword']]);
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->get();//->paginate(5);
        return view('users.index',compact('data'))
            // ->with('i', ($request->input('page', 1) - 1) * 5)
            ->with('title', 'Pengguna');
    }
    /**
     * Display view change password page
     *
     * @return \Illuminate\Http\Response
     */
    public function viewchangepassword()
    {
        $user = Auth::user();
        return view('users.ubahpassword',compact('user'))
            ->with('title', 'Pengguna');
    }
    /**
     * Change Password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changepassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        // dd('Password change successfully.');
        return redirect()->route('users.changepassword')
        ->with('success','Password berhasil diganti');

        // $this->validate($request, [
        //     'password' => 'same:confirm-password',
        //     'currentpassword' => 'required'
        // ]);
    
        // $user=User::find($id);
        // $input = $request->all();
        // $hashpass=Hash::make($input['currentpassword']);
        // if($hashpass==$user->password)
        // {
        //     $user->password=Hash::make($input['password']);
        //     $user->save();
        //     return redirect()->route('users.index')
        //     ->with('success','User updated successfully');
        // }
        // return redirect()->route('users.index')
        //                 ->with('failed','wrong password confirmation');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'))
        ->with('title', 'Pengguna');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        //validasi gambar
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $validated = $request->validate([
                'foto' => 'mimes:jpeg,jpg,png,svg|max:1014',
                ]);
                $name = $request->file('foto')->getClientOriginalName();
                // $request->file('foto')->storeAs('public/user_image',$name);
                Storage::disk('uploads')->put($name, file_get_contents($request->file('foto')));
                
                $input['foto'] = 'uploads/'.$name;
            }
        }

        //hash password
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id>1 && $id==1)
        {
            return redirect()->route('users.index')
            ->with('failed','Default admin user tidak bisa diedit');
        }
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'))
        ->with('title', 'Edit Pengguna');

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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        //validasi gambar
        $input = Arr::except($input,array('foto'));    
        if ($request->hasFile('foto')) {
            if ($request->file('foto')->isValid()) {
                $validated = $request->validate([
                'foto' => 'mimes:jpeg,jpg,png,svg|max:1014',
                ]);
                $name = $request->file('foto')->getClientOriginalName();
                // $request->file('foto')->storeAs('public/user_image',$name);
                Storage::disk('uploads')->put($name, file_get_contents($request->file('foto')));
                
                $input['foto'] = 'uploads/'.$name;
            }
        }

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id>1)
        {
            User::find($id)->delete();
            return redirect()->route('users.index')
                            ->with('success','User deleted successfully');
        }
        return redirect()->route('users.index')
        ->with('failed','Default admin user tidak bisa dihapus');
    }
}
