<?php

namespace App\Http\Controllers\Setting;

use App\User;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\UploadTrait;
use Vinkla\Hashids\Facades\Hashids;

class ProfileController extends Controller
{
    use UploadTrait;
    
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {   
        if ($request->isMethod('GET')) {
            return view('setting.profile.password');
        } else {
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }
            if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                //Current password and new password are same
                return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }
            $validatedData = $request->validate([
                'current-password' => 'required',
                'new-password' => 'required|string|min:6|confirmed',
            ]);
            //Change Password
            $user = Auth::user();
            $user->password =  Hash::make($request->get('new-password'));
            $user->save();
            return redirect()->back()->with("success","Password changed successfully !");
    
        }
    }

    public function changeProfile(Request $request)
    {   
        if ($request->isMethod('GET')) {

            $users = DB::table('users')
            ->select('users.*')
            ->where('users.id', Auth::user()->id)
            ->first();
            return view('setting.profile.form', compact('users'));
        } else {
            $validatedData = $request->validate([
                'email'     => 'required|email|unique:users,email,'.Auth::user()->id,
                'username'  => 'required|alpha_dash|unique:users,username,'.Auth::user()->id,
                'name'      => 'required',
            ]);
            
            $user = Auth::user();
            $user->name         = $request->get('name');
            $user->email        = $request->get('email');
            $user->username     = trim($request->get('username'));

            if ($request->has('image_url')) {
                $image = $request->file('image_url');
                $name = Str::slug($request->input('name')).'_'.time();
                $folder = '/uploads/images/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $this->uploadOne($image, $folder, 'public', $name);
                $user->image_url = $filePath;
            }
            $user->save();
            return redirect()->back()->with("success","Profile changed successfully !");
    
        }
    }

 

}
