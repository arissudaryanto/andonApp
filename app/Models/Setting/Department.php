<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';
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
        return $this->belongsTo('App\Models\Employee','department_id');
    }

    function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
