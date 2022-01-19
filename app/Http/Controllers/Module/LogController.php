<?php

namespace App\Http\Controllers\Module;

use App\Models\Module\Log;
use App\Models\Module\Notifications;
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
use App\Notifications\LogNotification;
// use Pusher\Pusher;

use Carbon\Carbon;
use Auth;
use File;
use Notification;

class LogController extends Controller
{

    /**
     * Display a listing of Maintenances.
     *
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request)
    {

        if($request->get('api_key') == null || $request->get('line') == null ||  $request->get('light') == null ){
            return response()->json(['errors' => 'All field is required'], 401);
        }else{
            $hardware = Hardware::where('device_id',$request->get('line'))
            ->where('status',1)
            ->first();

            if($hardware){
                if($hardware->light == $request->get('light')){
                    return response()->json(['errors' => 'Hardware already maintenance / or not trouble'], 401);
                }else{

                    $data['api_key']    = $request->get('api_key');
                    $data['line']       = $request->get('line');
                    $data['status']     = 0;
                    $status['light']    = $request->get('light');
                    $timestamp  = strtotime( date('Y-m-d H:i:s') ) - $request->get('delay');
            
                    if($request->get('light') == 'RED'){
                        $data['downtime']  = date('Y-m-d H:i:s', $timestamp);
                        $status['downtime']= date('Y-m-d H:i:s', $timestamp);
                    }
            
                    DB::beginTransaction();

                    try {
                       $hardware->update($status);
                        if($request->get('light') == 'GREEN'){
                            
                            Notifications::whereJsonContains('data->device_id',$request->get('line'))->whereNull('read_at')->update(['read_at' => date('Y-m-d H:i:s')]);;

                            $log = Log::where('line',$request->get('line'))->where('status',0)->first();
                            if($log){
                                $up['uptime'] = date('Y-m-d H:i:s', $timestamp);
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


    public function notification($hardware)
    {
        $data = [
            "device_id"  => $hardware->device_id,
            "body"       => $hardware->device_id. " is Down",
            "url"        => config('app.url')."maintenance_view_log/".$hardware->device_id,
        ];

       
        if($hardware->users){
            $user_id = json_decode($hardware->users);
            $users   = User::whereIn('id',$user_id)->get();
            Notification::send($users, new LogNotification($data));
        }else{
            return false;
        }

        // $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
        //     "instanceId" => \Config::get('services.pusher.beams_instance_id'),
        //     "secretKey" =>  \Config::get('services.pusher.beams_secret_key'),
        // ));
        
        // $publishResponse = $beamsClient->publishToInterests(
        // array("logs"),
        //     array("web"     => array("notification" => array(
        //         "title"       => "NOTIFICATION",
        //         "body"        => $hardware->device_id. " is Down",
        //         "deep_link"   => "http://127.0.0.1:8000/maintenance_log/".$hashLine,
        //     )),
        // ));
          
    }

}
