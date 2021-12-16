<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogHistory extends Model
{
    
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_log_histories';
    protected $guarded  = ['id'];

    
}
