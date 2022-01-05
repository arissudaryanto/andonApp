<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard\Sales;
use App\Models\Module\Dashboard;
use App\Models\Master\Hardware;
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
        $id = Auth::user()->id;

        $year = $request->get('year');
        if($request->get('year') == null){
            $year = date('Y');
        }
        $hardware = Dashboard::getHardware();
        $device   = Hardware::whereNull('deleted_at')
        ->whereJsonContains('users', ["$id"])
        ->where('status',1)->get();

        $entity   = Dashboard::getEntity($year);
        return view('dashboard.line',compact('entity','hardware','device'));
    }

}
