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
	}else if($status == 1){
		if($raw==null){
			return "<span class='badge bg-primary'>Procces</span>";
		}else{
			return "Process";
		}
	}else if($status == 3){
		if($raw==null){
			return "<span class='badge bg-success'>Closed</span>";
		}else{
			return "Closed";
		}
	}else{
		if($raw==null){
			return "<span class='badge bg-warning'>Hold</span>";
		}else{
			return "Hold";
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


function getPurchaser()
{
	$users = DB::table('users')->where('type',5)->where('data_access',NULL)
	->get();
	return $users ;
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
	if(Auth::user()->type==1){
		return true;
	}else{
		return false;
	}
}

function isAdministratorLocation() {
	if(Auth::user()->type==3){
		return true;
	}else{
		return false;
	}
}

function isEmployee () {
    if (Auth::user()->type==4) {
        return true;
    } else {
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
	}else{
			// Create two new DateTime-objects...
			$date1 = new DateTime($downtime);
			$date2 = new DateTime($uptime);

			// The diff-methods returns a new DateInterval-object...
			$diff = $date2->diff($date1);

			// Call the format method on the DateInterval-object
			return $diff->format('%a Day and %h hours');
	}
}