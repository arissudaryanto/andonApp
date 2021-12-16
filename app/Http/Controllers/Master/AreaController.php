<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Writer\Style\StyleBuilder;

class AreaController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:area.self', ['only' => ['index']]);
         $this->middleware('permission:area.create', ['only' => ['create','store']]);
         $this->middleware('permission:area.update', ['only' => ['edit','update']]);
         $this->middleware('permission:area.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of Areas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.area.index');
    }

    public function datatables()
    {
        
        $result= Area::whereNull('deleted_at');
        
       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $url_edit = "<a href='".route('master.area.edit', Hashids::encode($result->id))."' title='".trans('global.btn_edit')."' data-toggle='tooltip' class='btn btn-outline'><span class='fe-edit icon-lg'></span> </a>";  
          
            $url_delete = "<form class='delete' action='".route('master.area.destroy', $result->id)."' method='POST'>
                                <input name='_method' type='hidden' value='DELETE'>
                                ".csrf_field()."
                                <button type='submit' class='btn btn-outline text-danger' title='".trans('global.btn_delete')."' data-toggle='tooltip'><i class='fe-trash icon-lg'></i></button>
                            </form>";
            return
            '<div class="btn-group">'
                .$url_edit .$url_delete.
            '</div>';
        
        })->addColumn('status', function ($result){
            if($result->status==1){
                return "<span class='badge bg-success'>Aktif</span>";
            }else{
                return "<span class='badge bg-danger'>Non Aktif</span>";
            }
        })
        ->editColumn('updated_at', function ($result) {
            return $result->updated_at ? with(new Carbon($result->updated_at))->format('m/d/Y') : '';
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    /**
     * Show the form for creating new Areas.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('master.area.create');
    }

    /**
     * Store a newly created Areas in storage.
     *
     * @param  \App\Http\Requests\StoreAreassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->get('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $data['created_by'] = Auth::user()->id;
        $items = Area::create($data);
        return redirect()->route('master.area.index')->with(['success' => trans('global.success_store')]);
    }


    /**
     * Show the form for editing Areas.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $id = Hashids::decode($id);
        $items = Area::findOrFail($id['0']);
        return view('master.area.edit', compact('items'));
    }
    

    /**
     * Update Areas in storage.
     *
     * @param  \App\Http\Requests\  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $data = $request->all();
        if ($request->get('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $data['updated_by'] = Auth::user()->id;
        $items = Area::findOrFail($id);
        $items->update($data);
        return redirect()->route('master.area.index')->with(['success' => trans('global.success_update')]);
    }

    public function destroy($id)
    {
        $items  = Area::findOrFail($id);
        $data['updated_by'] = Auth::user()->id;
        $data['deleted_at'] = date('Y-m-d H:i:s');
        $items->update($data);
        return redirect()->route('master.area.index')->with(['success' => 'Delete was successful!']);
    }

    /**
     * Delete all selected Areas at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Area::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function get()
    {
        return  Area::whereNull('deleted_at')->get()->pluck('name','id');
    }


    public function export()
    {
        $query = Area::whereNull('deleted_at')
        ->orderBy('name','ASC')
        ->get();

        if( $query->isEmpty() ){
            return redirect()->route('master.area.index')->with(['error' => 'Tidak terdapat data untuk di Export']);
        }else{

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="your_name.xls"');
            header('Cache-Control: max-age=0');
            return (new FastExcel($query))->download('Master-Area-'.date('d-m-Y').'.xlsx', function ($inv) {
                return [
                    'ID'            => $inv->id,
                    'Kode'          => $inv->code,
                    'Nama'          => $inv->name,
                    'Status'        => ($inv->status == '1' ? 'Aktif' : 'Non Aktif')
                ];
            });
        }

    }

}
