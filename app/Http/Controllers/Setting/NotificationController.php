<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Notification;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadTrait;
use Vinkla\Hashids\Facades\Hashids;

class NotificationController extends Controller
{
    use UploadTrait;

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $notifications = DB::table('notifications')
        ->where('user_id', Auth::user()->id)
        ->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {   
        $id = Hashids::decode($id);
          
        $notification = Notification::findOrFail($id['0']);


        if($notification->status==0){
            $data['status'] = 1;
            $notification->update($data);
        }

        return redirect()->route($notification->link);
    
    }


}
