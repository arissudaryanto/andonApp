<?php

namespace App\Http\Controllers\Module;

use App\Models\Module\Log;
use App\Models\Module\Dashboard;
use App\Models\Master\Category;
use App\Models\Master\Area;
use App\Models\Master\Hardware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Auth;
use File;
use Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MaintenanceController extends Controller
{

    use UploadTrait;
       
    function __construct()
    {
        $this->middleware('permission:maintenance.self', ['only' => ['index']]);
        $this->middleware('permission:maintenance.create', ['only' => ['create','store']]);
        $this->middleware('permission:maintenance.update', ['only' => ['edit','update']]);
        $this->middleware('permission:maintenance.delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of Maintenances.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area  = Area::whereNull('deleted_at')->where('status',1)->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
        $category  = Category::whereNull('deleted_at')->where('status',1)->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
        $hardware  = Hardware::whereNull('deleted_at')->where('status',1)->get()->pluck('name', 'device_id')->prepend('Silahkan Pilih...', '');
        return view('module.maintenance.index',compact('category','hardware'));
    }

    public function datatables($status =  null)
    {
      
       $result = Hardware::
       select('hardwares.*')
       ->where('status',1)
       ->whereNull('deleted_at')->orderBy('created_at','ASC');

       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $action = "<a href='".route('maintenance.log', Hashids::encode($result->id))."' title='Tampilkan' data-toggle='tooltip' class='btn btn-sm btn-outline'><span class='fe-eye icon-lg'></span></a>";
            return $action;
        })
        ->addColumn('status', function ($result){
            if($result->status=='1'){
                return "<span class='badge bg-success'>Aktif</span>";
            }else{
                return "<span class='badge bg-danger'>Non Aktif</span>";
            }
        })
        ->editColumn('light', function ($result){
            return getStatusLight($result->light);
        })
        ->editColumn('downtime', function ($result) {
            return $result->downtime ? with(new Carbon($result->downtime))->format('d-m-Y H:i:s') : '-';
        })
        ->rawColumns(['action', 'status','light'])
        ->make(true);

    }

    public function log(Request $request, $id)
    {
        $year = $request->get('year');
        if($request->get('year') == null){
            $year = date('Y');
        }

        $id        = Hashids::decode($id);
        $hardware  = Hardware::findOrFail($id['0']);
        $statistic = Dashboard::getEntity($year,$hardware->device_id);
        $category  = Category::whereNull('deleted_at')->where('status',1)->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
        return view('module.maintenance.log',compact('category','hardware','statistic'));
    }


    public function log_datatables($line)
    {
      
       $result = Log::
       select('data_logs.*',
        'categories.name as category',
       )
       ->leftJoin('categories', 'categories.id', '=', 'data_logs.category_id')
       ->where('data_logs.line',$line)
       ->orderBy('data_logs.created_at','DESC');

       return  DataTables::of($result)
        ->addColumn('action', function ($result) {
            $action = "<a href='".route('maintenance.add', ['id' => Hashids::encode($result->id),'line' => $result->line ])."' title='Follow Up' data-toggle='tooltip' class='dropdown-item'><span class='fa fa-tools icon-lg'></span></a>";
            return $action;
        }) 
        ->addColumn('status', function ($result){
            return getStatusData($result->status);
        })
        ->addColumn('range', function ($result){
            return getDowntime($result->downtime, $result->uptime);
        })
        ->editColumn('downtime', function ($result) {
            return $result->downtime ? with(new Carbon($result->downtime))->format('d-m-Y H:i:s') : '-';
        })
        ->editColumn('uptime', function ($result) {
            return $result->uptime ? with(new Carbon($result->uptime))->format('d-m-Y H:i:s') : '-';
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    /**
     * Show the form for creating new Maintenances.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $id   = Hashids::decode($id);
        $data = Log::findOrFail($id['0']);
        if($data->line == $request->get('line') ){
            $hardware = Hardware::where('device_id',$request->get('line'))->first();
            $category = Category::whereNull('deleted_at')->where('status',1)->get()->pluck('name', 'id')->prepend('Silahkan Pilih...', '');
            return view('module.maintenance.create',compact('data','category','hardware'));
        }else{
            return redirect()->route('maintenance.index')->withErrors(['erorr' => 'Data tidak sesuai']);
        }

    }

    /**
     * Store a newly created Maintenances in storage.
     *
     * @param  \App\Http\Requests\StoreMaintenancessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['assigned_by'] = Auth::user()->id;
       // $data['number'] = \Config::get('app.prefix_number')."-".date('m').'-'.date('Y')."-".Str::random(6);
        
        DB::beginTransaction();

        try {

            $log =  Log::findOrFail($request->get('data_log_id'));
            $log->update($data);

            DB::commit();
            return redirect()->route('maintenance.log',Hashids::encode($request->get('hardware_id')))->with(['success' => trans('global.success_store')]);
    
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing Maintenances.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        $id    = Hashids::decode($id);
        $data  = Log::findOrFail($id['0']);
        return view('module.maintenance.show', compact('data'))->renderSections()['content'];
    }
    

    public function export(Request $request)
    {
      
            $data = $request->all();

            $query = Log::
            select(
                'data_logs.*',
                'categories.name AS category',
                'users.name as user')
            ->leftJoin('categories', 'categories.id', '=', 'data_logs.category_id')
            ->leftJoin('users', 'users.id', '=', 'data_logs.assigned_by')
            ->when(!empty($data['category_id']), function ($query) use ($data) {
                return $query->where('data_logs.category_id',$data['category_id']);
            })
            ->when(!empty($data['line']), function ($query) use ($data) {
                return $query->where('data_logs.line',$data['line']);
            })
            ->when(!empty($data['start_date']), function ($query) use ($data) {
                if($data['end_date']){
                    $start = date("Y-m-d",strtotime($data['start_date']));
                    $end   = date("Y-m-d",strtotime($data['end_date']."+1 day"));
                    return $query->whereBetween('data_logs.created_at', [$start , $end]);
                }else{
                    return $query->where('data_logs.created_at', $data['start_date']);
                }
            })
            ->orderBy('data_logs.created_at','DESC')
            ->get();

            if( $query->isEmpty() ){
                return redirect()->route('maintenance.index')->withInput()->withErrors('Tidak terdapat data untuk di Export');
            }else{
                $styleArrayTabel = array(
                'alignment' => array(
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            'wrap'       => true
                ),
                'borders' => array(
                    'allBorders' => array(
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //BORDER_THIN BORDER_MEDIUM BORDER_HAIR
                            'color' => array('rgb' => '000000')
                    )
                    )
                );
        
                $styleArrayItem = array(
                    'alignment' => array(
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'rotation'   => 0,
                            'wrap'       => true
                    ),
                    'borders' => array(
                        'allBorders' => array(
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, //BORDER_THIN BORDER_MEDIUM BORDER_HAIR
                                'color' => array('rgb' => '000000')
                        )
                        )
                );

                $styleArrayBorder = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        ],
                    ],
                ];

                $spreadsheet = new Spreadsheet();
                $spreadsheet->getActiveSheet()->setTitle('ERROR REPORTING');

                $drawing = new Drawing();

                $sheet      = $spreadsheet->getActiveSheet();
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setScale(80);
                
                $sheet->getPageMargins()->setTop(0.24);
                $sheet->getPageMargins()->setRight(0.2);
                $sheet->getPageMargins()->setLeft(0.2);
                $sheet->getPageMargins()->setBottom(0.24);

                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setScale(80);
                
                $sheet->getPageMargins()->setTop(0.24);
                $sheet->getPageMargins()->setRight(0.2);
                $sheet->getPageMargins()->setLeft(0.2);
                $sheet->getPageMargins()->setBottom(0.24);
        
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setWidth(30);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
                $sheet->getColumnDimension('I')->setAutoSize(true);
                $sheet->getColumnDimension('J')->setAutoSize(true);

                $sheet->setCellValue('B2', strtoupper(\Config::get('app.company_name')));
                $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B2')->getAlignment()->setIndent(14);
                $sheet->setCellValue('B3', \Config::get('app.company_address'));
                $sheet->getStyle('B3')->getAlignment()->setIndent(14);
                $sheet->setCellValue('B4', 'Telp: '. \Config::get('app.company_telp'). ' Email: '.\Config::get('app.company_mail'));
                $sheet->getStyle('B4')->getAlignment()->setIndent(14);
                
                $sheet->setCellValue('B6', 'ERORR REPORTING');
                $sheet->getStyle('B6')->getFont()->setBold(true)->setUnderline(true);

                $sheet->setCellValue('B8', 'Damaged Category');
                if($request->input('category_id')){
                    $category = Category::find($request->input('category_id'));
                    $sheet->setCellValue('C8', ': '. $category->name);
                }else{
                    $sheet->setCellValue('C8', ': All');
                }

                $sheet->setCellValue('B9', 'Period');
                $sheet->setCellValue('C9', ': '.date('d M Y',strtotime($request->input('start_date')))." s/d ".date('d M Y',strtotime($request->input('end_date'))));

                $sheet->setCellValue('A12', 'NO');
                $sheet->setCellValue('B12', 'LINE/TROLLEY ID');
                $sheet->setCellValue('C12', 'GROUP AREA');
                $sheet->setCellValue('D12', 'TIMESTAMP RED');
                $sheet->setCellValue('E12', 'TIMESTAMP GREEN');
                $sheet->setCellValue('F12', 'DOWNTIME');
                $sheet->setCellValue('G12', 'CATEGORY');
                $sheet->setCellValue('H12', 'DETAIL');
                $sheet->setCellValue('I12', 'MAINTANER');
                $sheet->setCellValue('J12', 'STATUS');
                $sheet->getStyle('A12:J12')->getFont()->setBold(true);
                $sheet->getStyle('A12:J12')->applyFromArray($styleArrayItem);
        
                $rows = 13;
                $no   = 1 ;
        
                foreach ($query as $item){

                    $sheet->setCellValue('A' . $rows, $no);
                    $sheet->setCellValue('B' . $rows, $item->line);
                    $sheet->setCellValue('C' . $rows, $item->light);
                    $sheet->setCellValue('D' . $rows, isset($item->downtime) ? date('d M Y H:i:s', strtotime($item->downtime)) : '');
                    $sheet->setCellValue('E' . $rows, isset($item->uptime) ? date('d M Y H:i:s', strtotime($item->uptime)) : '');
                    $sheet->setCellValue('F' . $rows, getDowntime($item->downtime, $item->uptime));
                    $sheet->setCellValue('G' . $rows, $item->category);
                    $sheet->setCellValue('H' . $rows, $item->description);
                    $sheet->setCellValue('I' . $rows, $item->user);
                    $sheet->setCellValue('J' . $rows, getStatusData($item->status,'raw'));

                    $sheet->getStyle('A' . $rows.':J'.$rows)->applyFromArray($styleArrayTabel);
                    $sheet->getStyle('G' . $rows)->getAlignment()->setWrapText(true); 

                    $rows = $rows + 1;
                    $no++;
                }
                
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Erorr Maintancne -'.date('d M Y').'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save("php://output");
                die();
  
        }
    }


}
