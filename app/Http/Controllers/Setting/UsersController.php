<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;    
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use App\Traits\UploadTrait;

class UsersController extends Controller
{
   
    function __construct()
    {
         $this->middleware('permission:user.self', ['only' => ['index']]);
         $this->middleware('permission:user.create', ['only' => ['create','store']]);
         $this->middleware('permission:user.update', ['only' => ['edit','update','password','update_password']]);
         $this->middleware('permission:user.delete', ['only' => ['destroy']]);

    }

    use UploadTrait;
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.users.index');
    }


    public function datatables()
    {
       
        $result = DB::table('users');

       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $url_edit  = "<a href='".route('setting.users.edit', $result->id)."' title='".trans('global.btn_edit')."' data-bs-toggle='tooltip' class='btn btn-outline'><span class='fe-edit icon-lg'></span> </a>";  
            $url_reset = "<a href='".route('setting.users.password', Hashids::encode($result->id))."' title='Reset Password' data-bs-toggle='tooltip' class='btn btn-outline'><span class='fe-lock icon-lg'></span> </a>";  
            $url_delete = "<form class='delete' action='".route('setting.users.destroy', $result->id)."' method='POST'>
                                <input name='_method' type='hidden' value='DELETE'>
                                ".csrf_field()."
                                <button class='btn btn-outline text-danger' title='".trans('global.btn_delete')."' data-toggle='tooltip'><i class='fe-trash icon-lg'></i></button>
                            </form>";
            return
                '<div class="btn-group">'
                 .$url_edit .$url_reset .$url_delete.
                '</div>';
        }) 
        ->editColumn('updated_at', function ($result) {
            return $result->updated_at ? with(new Carbon($result->updated_at))->format('m/d/Y') : '';
        })
        ->make(true);

    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $roles   = Role::get()->pluck('name', 'name');
        return view('setting.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        $data = $request->all();

        if ($request->has('image_url')) {
            $image = $request->file('image_url');
            $name  = Str::random(25);
            $folder= '/uploads/images/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $data['image_url'] = $filePath;
        }
        $data['name']     = strtoupper($request->get('name'));
        $data['password'] = Hash::make(123456);
        $user = User::create($data);

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return redirect()->route('setting.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $roles  = Role::get()->pluck('name', 'id');
        $user   = User::findOrFail($id);
        return view('setting.users.edit', compact('user', 'roles'));
    }


     /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function password($id)
    {
        $id = Hashids::decode($id);
        $user = User::findOrFail($id['0']);
        $user->password = Hash::make(123456);
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
      
        $dataUser = $request->all();

        if ($request->has('image_url')) {
            $image = $request->file('image_url');
            $name  = Str::random(25);
            $name = str_slug($request->get('name')).'_'.time();
            $folder = '/uploads/images/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $dataUser['image_url'] = $filePath;
        }

        $dataUser['name'] = strtoupper($request->get('name'));

        $user = User::findOrFail($id);
        $user->update($dataUser);

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);

        return redirect()->route('setting.users.index')->with(['success' => trans('global.success_update')]);
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('setting.users.index');
    }

    public function get(Request $request)
    {
        if ($request->has('q')) {
            $query = User::where('users.name', 'ilike','%'.$request->q.'%')
            ->get();

            $result = array();
            foreach ($query as $val) {
                $result[] = array('id' => $val->id, 'name' =>$val->name);
            }
            return response()->json($result);
        }
    }

    public function AuthRouteAPI(Request $request){
        return $request->user();
     }
}
