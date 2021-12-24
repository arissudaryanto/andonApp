<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_logs';
    protected $guarded  = ['id'];

  
   public function user(){
      return $this->belongsTo('App\Models\User','created_by');
   }

   public function category(){
      return $this->belongsTo('App\Models\Master\Category','category_id');
   }

}
