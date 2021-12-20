<?php

namespace App\Http\Controllers\Module;

use App\Models\Module\Log;
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

class LogController extends Controller
{

    /**
     * Display a listing of Maintenances.
     *
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request)
    {
        
        $data['api_key']    = $request->get('api_key');
        $data['line']       = $request->get('line');
        $data['light']      = $request->get('light');
        $data['status']     = 0;
        $status['light']    = $request->get('light');
        if($request->get('light') == 'RED'){
            $status['downtime']    = date('Y-m-d H:i:s');
        }

        if($request->get('light') == 'GREEN'){
            $status['uptime']    = date('Y-m-d H:i:s');
        }

        if($request->get('api_key') == null || $request->get('line') == null ||  $request->get('light') == null ){
            return response()->json(['errors' => 'All field is required'], 401);
        }else{
            $hardware = Hardware::where('device_id',$request->get('line'))->first();

            if($hardware){

                DB::beginTransaction();

                try {
                    $hardware->update($status);
                    Log::create($data);
                    DB::commit();
                    return response()->json(['success' => 'Success'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }
            }else{
                return response()->json(['errors' => 'Device ID not found'], 401);
            }
        }

    }

}
