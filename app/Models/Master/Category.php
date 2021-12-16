<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps  = [ "created_at" ];
    protected $table    = 'categories';
    protected $guarded  = ['id'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   
   public function setUpdatedAt($value)
   {
     return NULL;
   }


}
