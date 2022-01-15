<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard\Sales;
use App\Models\Module\Dashboard;
use App\Models\Master\Hardware;
use Illuminate\Support\Facades\Gate;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Gate::allows('dashboard.self')) {
            $id = Auth::user()->id;

            $year = $request->get('year');
            if($request->get('year') == null){
                $year = date('Y');
            }
            $hardware = Dashboard::getHardware();
            if(isAdministrator()){
                $device   = Hardware::
                select('hardwares.*')
                ->where('status',1)
                ->whereNull('deleted_at')->orderBy('created_at','ASC')->get();
           }else{
                $device   = Hardware::
                select('hardwares.*')
                ->whereJsonContains('users', ["$id"])
                ->where('status',1)
                ->whereNull('deleted_at')->orderBy('created_at','ASC')->get();
           }

            $entity   = Dashboard::getEntity($year);
            return view('dashboard.line',compact('entity','hardware','device'));
        }else{
            return redirect()->route('maintenance.index');
        }
    }

    public function notify()
    {
       
    }
}
