<?php

namespace App\Http\Controllers\Module;

use App\Models\Module\Log;
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
        $data['light']      = $request->get('light');
        $data['status']     = 0;


        DB::beginTransaction();

        try {

            Log::create($data);

            DB::commit();
            return response()->json(['success' => 'success'], 200);
    
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
