<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard\Sales;
use App\Models\Module\Dashboard;
use App\Models\Master\Hardware;


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
        $year = $request->get('year');
        if($request->get('year') == null){
            $year = date('Y');
        }

        if(isAdministrator()){

            $hardware   = Dashboard::getHardware();
            $entity     = Dashboard::getEntity($year);
            $category   = Dashboard::getByCategory($year);
            $area       = Dashboard::getByArea($year);
            $priority   = Dashboard::getPriority($year);
            $day        = Dashboard::getByDay($year);
    
            return view('dashboard.index',compact('year','entity','category','area','priority','hardware'));
        }else{
            $hardware = Dashboard::getHardware();
            $device   = Hardware::whereNull('deleted_at')->get();
            $entity   = Dashboard::getEntity($year);
            return view('dashboard.line',compact('entity','hardware','device'));
        }
       
    }

}
