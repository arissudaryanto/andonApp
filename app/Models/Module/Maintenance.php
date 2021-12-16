<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maintenance extends Model
{
    
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'maintenances';
    protected $guarded  = ['id'];

  
   public function user(){
      return $this->belongsTo('App\Models\User','assigned_by');
   }
    
   public function category(){
      return $this->belongsTo('App\Models\Master\Category','category_id');
   }
}
