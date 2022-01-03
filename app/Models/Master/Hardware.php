<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;

use App\Models\Module\Log;

class Hardware extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hardwares';
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

      /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */

    public function log(){
        return $this->hasMany(Log::class,'line','device_id')->whereDate('created_at', '=', Carbon::today())->get();
    }


    public function getDowntime(){
      $data = $this->log();
      $diffInSeconds = 0;
      foreach ($data as $item){
        $date1 = new DateTime($item->downtime);
			  $date2 = new DateTime($item->uptime);
        $diffInSeconds += $date2->getTimestamp() - $date1->getTimestamp();
      }

      return $this->secondsToTime($diffInSeconds);
   }


   function secondsToTime($seconds) {
      $dtF = new \DateTime('@0');
      $dtT = new \DateTime("@$seconds");
      return $dtF->diff($dtT)->format('%ad %hh %im %ss');
  }
}
