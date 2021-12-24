<?php

namespace App\Http\Controllers\Module;

use App\Models\Module\Log;
use App\Models\User;
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
use Pusher\Pusher;

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
        $data['status']     = 0;
        $status['light']    = $request->get('light');

        if($request->get('light') == 'RED'){
            $data['downtime']    = date('Y-m-d H:i:s');
            $status['downtime']  = date('Y-m-d H:i:s');
        }


        if($request->get('api_key') == null || $request->get('line') == null ||  $request->get('light') == null ){
            return response()->json(['errors' => 'All field is required'], 401);
        }else{
            $hardware = Hardware::where('device_id',$request->get('line'))->first();

            if($hardware){
                if($hardware->light == $request->get('light')){
                    return response()->json(['errors' => 'Hardware already maintenance / or not trouble'], 401);
                }else{

                    DB::beginTransaction();

                    try {
                        $hardware->update($status);
                        if($request->get('light') == 'GREEN'){
                            $log = Log::where('line',$request->get('line'))->where('status',0)->first();
                            if($log){
                                $up['uptime'] = date('Y-m-d H:i:s');
                                $up['status'] = 1;
                                $log->update($up);
                            }
                        }else{
                            Log::create($data);
                        }
                        DB::commit();
                        if($request->get('light') == 'RED'){
                            $this->notification($hardware);
                        }
                        return response()->json(['success' => 'Success'], 200);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                    }
                }
            }else{
                return response()->json(['errors' => 'Hardware ID not found'], 401);
            }
        }

    }


    public function notification($hardware )
    {
        $hashLine = Hashids::encode($hardware->id);
        $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => "54bd92a7-c38b-4e3f-b148-2d89a80e9a83",
            "secretKey" => "B32A8EDAB2167814ADD03B94ABBE79FE3B78AE1E3BD5739A622BDC6902948D2A",
          ));
          
          $publishResponse = $beamsClient->publishToInterests(
            array("logs"),
            array("web"     => array("notification" => array(
              "title"       => "NOTIFICATION",
              "body"        => $hardware->device_id. " is Downtime",
              "deep_link"   => "http://127.0.0.1:8000/maintenance_log/".$hashLine,
            )),
          ));
 
    }

}
