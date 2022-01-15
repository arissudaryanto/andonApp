<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notifications extends Model
{
    
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    protected $guarded  = ['id'];

  
}
