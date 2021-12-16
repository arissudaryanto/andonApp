<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Auth;
use File;

use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Writer\Style\StyleBuilder;

class CategoryController extends Controller
{

       
    function __construct()
    {
        $this->middleware('permission:category.self', ['only' => ['index']]);
         $this->middleware('permission:category.create', ['only' => ['create','store']]);
         $this->middleware('permission:category.update', ['only' => ['edit','update']]);
         $this->middleware('permission:category.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of Categorys.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.category.index');
    }

    public function datatables()
    {
      
        $result = Category::whereNull('deleted_at')->orderBy('name','ASC');

       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $url_edit = "<a href='".route('master.category.edit', Hashids::encode($result->id))."' title='".trans('global.btn_edit')."' data-toggle='tooltip' class='btn btn-outline'><span class='fe-edit icon-lg'></span> </a>";  
            $url_delete = "<form class='delete' action='".route('master.category.destroy', $result->id)."' method='POST'>
                                <input name='_method' type='hidden' value='DELETE'>
                                ".csrf_field()."
                                <button type='submit' class='btn btn-outline text-danger' title='".trans('global.btn_delete')."' data-toggle='tooltip'><i class='fe-trash icon-lg'></i></button>
                            </form>";
            return
                '<div class="btn-group">'
                 .$url_edit .$url_delete.
                '</div>';
        }) 
        ->addColumn('status', function ($result){
            if($result->status=='1'){
                return "<span class='badge bg-success'>Aktif</span>";
            }else{
                return "<span class='badge bg-danger'>Non Aktif</span>";
            }
        })
        ->editColumn('updated_at', function ($result) {
            return $result->updated_at ? with(new Carbon($result->updated_at))->format('d-m-Y H:i:s') : '';
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    /**
     * Show the form for creating new Categorys.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.category.create');
    }

    /**
     * Store a newly created Categorys in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryssRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $items = Category::create($data);
        return redirect()->route('master.category.index')->with(['success' => trans('global.success_store')]);
    }


    /**
     * Show the form for editing Categorys.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        $id    = Hashids::decode($id);
        $items = Category::findOrFail($id['0']);
        return view('master.category.edit', compact('items'));
    }
    

    /**
     * Update Categorys in storage.
     *
     * @param  \App\Http\Requests\  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
   
        $data = $request->all();
        if($request->get('status')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        $data['updated_by'] = Auth::user()->id;
        $items = Category::findOrFail($id);
        $items->update($data);

        return redirect()->route('master.category.index')->with(['success' => trans('global.success_update')]);
    
    }

    /**
     * Remove Categorys from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items  = Category::findOrFail($id);
        $data['updated_by'] = Auth::user()->id;
        $data['deleted_at'] = date('Y-m-d H:i:s');
        $items->update($data);
        return redirect()->route('master.category.index')->with(['success' => 'Delete was successful!']);
    }


    public function export()
    {
        $query = Category::orderBy('id','ASC')
        ->get();

        if( $query->isEmpty() ){
            return redirect()->route('master.item_brands.index')->with(['error' => 'Tidak terdapat data untuk di Export']);
        }else{
            $style = (new StyleBuilder())
            ->setFontBold()
            ->build();

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="your_name.xls"');
            header('Cache-Control: max-age=0');
            return (new FastExcel($query))->headerStyle($style)->download('Master-Category'.date('d-m-Y').'.xlsx', function ($data) {
                return [
                    'ID'            => $data->id,
                    'Nama'          => $data->name,
                    'Status'        => ($data->status == '1' ? 'Aktif' : 'Non Aktif')
                ];
            });
        }

    }


}
