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
                            $this->sendNotification();
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


    public function sendNotification()
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = 'AAAAgroMrME:APA91bFg3SICOMCE4wBoqyQrr_80r9cykjAs8nkcr_H6RC-yrnJisfQ_AyC7QG1XJ2fB3AIHb9GIAyPK9IeYI8CMzrAYcxItohxRN9I47u0AlHMVUE4UlKvG-j4rBcXwEhROUbMdo-2A';
  
        $data = [
            "to" => '/topics/log',
            "notification" => [
                "title" => 'Error Log',
                "body" => 'Terdapat Sinyal',  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }

}
