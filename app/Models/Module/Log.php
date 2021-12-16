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
    protected $table = 'data_log';
    protected $guarded  = ['id'];

  
   public function user(){
      return $this->belongsTo('App\Models\User','created_by');
   }

   public function maintenance(){
      return $this->hasOne(Maintenance::class,'data_log_id');
   }

   public function history(){
      return $this->hasMany(LogHistory::class,'data_log_id');
   }
    
}
