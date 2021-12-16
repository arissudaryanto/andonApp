<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'positions';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $guarded    = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    function employee(){
        return $this->belongsTo('App\Models\Employee','position_id');
    }

    function department(){
        return $this->belongsTo(Company::class,'department_id');
    }
}
