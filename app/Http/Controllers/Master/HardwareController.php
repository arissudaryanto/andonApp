<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Hardware;
use App\Models\Master\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Exports\HardwareExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use File;
use App\Traits\UploadTrait;
use Rap2hpoutre\FastExcel\FastExcel;
use Box\Spout\Writer\Style\StyleBuilder;

class HardwareController extends Controller
{

    use UploadTrait;
      
    function __construct()
    {
         $this->middleware('permission:hardware.self', ['only' => ['index']]);
         $this->middleware('permission:hardware.create', ['only' => ['create','store']]);
         $this->middleware('permission:hardware.update', ['only' => ['edit','update']]);
         $this->middleware('permission:hardware.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of Items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.hardware.index');
    }

    public function datatables()
    {

        $result = Hardware::whereNull('deleted_at');

       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $action = "<a href='".route('master.hardware.show', Hashids::encode($result->id))."' title='Tampilkan' data-toggle='tooltip' class='dropdown-item'><span class='fe-eye icon-lg'></span> Tampilkan</a>";
            $action .= "<a href='".route('master.hardware.edit', Hashids::encode($result->id))."' title='".trans('global.btn_edit')."' data-toggle='tooltip' class='dropdown-item'><span class='fe-edit'></span> Edit</a>";
            $action .= "<form class='delete' action='".route('master.hardware.destroy',  $result->id)."' method='POST'>
                                <input name='_method' type='hidden' value='DELETE'>
                                ".csrf_field()."
                                <button class='dropdown-item text-danger' title='".trans('global.btn_delete')."' data-toggle='tooltip'><i class='fe-trash icon-lg'></i> Hapus</button>
                            </form>";
            return
                '<div class="dropdown">
                    <a class="btn btn-outhardware border dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Aksi <div class="arrow-down"></div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'
                        .$action.
                    '</div>
                </div>';
        })
        ->addColumn('status', function ($result){
            if($result->status=='1'){
                return "<span class='badge bg-success'>Aktif</span>";
            }else{
                return "<span class='badge bg-danger'>Non Aktif</span>";
            }
        })
        ->editColumn('updated_at', function ($result) {
            return $result->updated_at ? with(new Carbon($result->updated_at))->format('d/m/Y H:i:s') : '';
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    /**
     * Show the form for creating new Items.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = Area::whereNull('deleted_at')->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
        return view('master.hardware.create', compact('area'));
    }

    /**
     * Store a newly created Items in storage.
     *
     * @param  \App\Http\Requests\StoreItemssRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $data = $request->all();

        if($request->hasFile('file')){
            $file = $request->file('file');
            $name = Str::random(25);
            $folder = '/uploads/images/'.date('Y').'/'.date('M').'/';
            $filePath = $folder . $name. '.' . $file->getClientOriginalExtension();
            $this->uploadResize($file, $folder, 'public', $name);
            $data['image_url'] = $filePath;
        }
        $data['created_by'] = Auth::user()->id;
        $data['light']      = 'GREEN';

        if ($request->get('status')) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        Hardware::create($data);

        return redirect()->route('master.hardware.index')->with(['success' => trans('global.success_store')]);


    }


    /**
     * Show the form for editing Items.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Hashids::decode($id);
        $item = Hardware::findOrFail($id['0']);
        $area = Area::whereNull('deleted_at')->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
        return view('master.hardware.edit', compact('item','area'));
    }


    public function show($id)
    {
        $id     = Hashids::decode($id);
        $item   = Hardware::findOrFail($id['0']);
        return view('master.hardware.show', compact('item'));
    }
    /**
     * Update Items in storage.
     *
     * @param  \App\Http\Requests\  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $data = $request->all();

        $data['status'] = 0;
        if ($request->get('status')) {
            $data['status'] = 1;
        }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $name = Str::random(25);
            $folder = '/uploads/images/'.date('Y').'/'.date('M').'/';
            $filePath = $folder . $name. '.' . $file->getClientOriginalExtension();
            $this->uploadResize($file, $folder, 'public', $name);
            $data['image_url'] = $filePath;
        }   

        $data['updated_by'] = Auth::user()->id;
        $items = Hardware::findOrFail($id);
        $items->update($data);

        return redirect()->route('master.hardware.index')->with(['success' => trans('global.success_update')]);
    }

    public function destroy($id)
    {
        $items  = Hardware::findOrFail($id);
        $data['updated_by'] = Auth::user()->id;
        $data['deleted_at'] = date('Y-m-d H:i:s');
        $items->update($data);
        return redirect()->route('master.hardware.index')->with(['success' => 'Delete was successful!']);
    }


    public function export(Request $request)
    {
        $data = $request->all();

        $query = Hardware::whereNull('deleted_at')
        ->when(!empty($data['category_id']), function ($query) use ($data) {
            return $query->where('product_category_id',$data['category_id']);
        })
        ->get();

        if( $query->isEmpty() ){
            return redirect()->route('master.hardware.index')->with(['error' => 'Tidak terdapat data untuk di Export']);
        }else{
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="your_name.xls"');
            header('Cache-Control: max-age=0');
            return (new FastExcel($query))->download('product-'.date('d-m-Y').'.xlsx', function ($data) {

                return [
                    'Device ID'    => $data->device_id,
                    'Nama'   => $data->name,
                    'Status'        => ($data->status == '1' ? 'Y' : 'N'),
                    'Tgl Input'     => dateTextMySQL2ID($data->created_at),
                    'Tgl Perbaharui'=> dateTextMySQL2ID($data->updated_at),
                ];
            });
        }

    }


    public function import(Request $request){

        if($request->isMethod('get'))
        {
            return view('master.hardware.upload');
        }
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));

        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

                $item       = Hardware::where("id", $request->get('item_id'))->first();
                $countID    = Hardware::where('item_id',$item->id)->count();
                $userID     = Auth::user()->id;

                $file = $request->file('file');
                try {
                    Excel::import(new HardwareImport( $item->code,$countID, $request->get('item_id'), $userID), $file);
                } catch (\Exception $e) {
                    return Redirect::back()
                    ->withInput($request->input())
                    ->withErrors(['Terdapat Template yang belum sesuai']);
                }
                return redirect()->route('master.hardware.index')->with(['success' => 'Success inserting the data..']);

            } else {
                return redirect()->route('master.hardware.index')->with(['error' =>' File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!']);
            }
        }
    }


}
