<?php

namespace App\Http\Controllers\Setting;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PermissionsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:permission.self', ['only' => ['index']]);
        $this->middleware('permission:permission.create', ['only' => ['create','store']]);
         $this->middleware('permission:permission.update', ['only' => ['edit','update']]);
        $this->middleware('permission:permission.delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('setting.permissions.index', compact('permissions'));
    }

    public function datatables()
    {
        $result = DB::table('permissions');
        return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $url_edit = "<a href='".route('setting.permissions.edit', $result->id)."' title='".trans('global.btn_edit')."' data-toggle='tooltip' class='btn btn-outline'><span class='fe-edit icon-lg'></span> </a>";  
            $url_delete = "<form class='delete' action='".route('setting.permissions.delete', ['id' => $result->id])."' method='POST'>
                                ".csrf_field()."
                                <button class='btn btn-outline text-danger' title='".trans('global.btn_delete')."' data-toggle='tooltip'><i class='fe-trash icon-lg'></i></button>
                            </form>";
            return
                '<div class="btn-group">'
                 .$url_edit .$url_delete.
                '</div>';
        }) 
        ->editColumn('updated_at', function ($result) {
            return $result->updated_at ? with(new Carbon($result->updated_at))->format('m/d/Y') : '';
        })
        ->make(true);

    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->all());
        return redirect()->route('setting.permissions.index');
    }


    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('setting.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        return redirect()->route('setting.permissions.index');
    }


    public function delete(Request $request)
    {

        $permission = Permission::findOrFail($request->id);
        $permission->delete();
        return redirect()->route('setting.permissions.index');

    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Permission::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
