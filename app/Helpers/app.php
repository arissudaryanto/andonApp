<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Log;


function getStatusLight($status)
{
	if($status == 'RED'){
		return "<span class='badge bg-danger'>&nbsp;</span>";
	}else{
		return "<span class='badge bg-success'>&nbsp;</span>";
	}
}



function getStatusData($status, $raw = null)
{
	if($status == 0){
		if($raw==null){
			return "<span class='badge bg-info'>Open</span>";
		}else{
			return "Open";
		}
	}else {
		if($raw==null){
			return "<span class='badge bg-success'>Closed</span>";
		}else{
			return "Closed";
		}
	}
}



function getNotifications($user_id)
{
	$query = DB::table('notifications')
	->select('*')
	->where('user_id', $user_id)
	->where('status', 0)
	->get();
	return $query;
}


function getDataUsersByID($id)
{
	$data= DB::table('users')
	->select('*')
	->whereIn('id', $id)
	->get();
   return $data;

}


function isAdministrator() {
	if(Auth::user()->with('roles')->first()->name=='SuperAdmin'){
		return true;
	}else{
		return false;
	}
}
 

function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}

function getChecked($val, $arr){
	if($val == $arr){
		echo 'checked';
	}
}


function format_number($val){
	return number_format($val,2,",",'.');
}


function getTotalDowntime ($deviceID) {
	$sql = "
	SELECT 
	*
	FROM data_logs`
  	WHERE `line` = '".$deviceID."' AND DATE_FORMAT(created_at, '%Y-%m-%d') = CURDATE()
	";
	
	return  DB::select( DB::raw($sql));

}

function is_connected()
{
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
        $is_conn = true;
        fclose($connected);
    }else{
        $is_conn = false; 
    }
    return $is_conn;

}


function getStatusLine ($deviceID) {
	$sql = "
	SELECT 
	*
	FROM data_log
  	WHERE `line` = '".$deviceID."' and status != 3 
  	ORDER BY created_at DESC LIMIT 1";
	
	return  DB::select( DB::raw($sql));

}


function getDowntime ($downtime, $uptime) {

	if($downtime == null || $uptime == null){
		return '-';
	} else{
			// Create two new DateTime-objects...
			$date1 = new DateTime($downtime);
			$date2 = new DateTime($uptime);

			// The diff-methods returns a new DateInterval-object...
			$diff = $date2->diff($date1);

			// Call the format method on the DateInterval-object
			return $diff->format('%ad %hh %im %ss');
	}
}


function secondsToTime($seconds) {
	$dtF = new \DateTime('@0');
	$dtT = new \DateTime("@$seconds");
	return $dtF->diff($dtT)->format('%ad %hh %im %ss');
}



function notify() {
	return auth()->user()->unreadNotifications;
}