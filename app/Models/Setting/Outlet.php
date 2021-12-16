<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps  = [ "created_at" ];
    protected $table    = 'outlets';
    protected $guarded  = ['id'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   

    function company(){
        return $this->belongsTo('App\Models\Setting\Company','company_id');
    }

}
