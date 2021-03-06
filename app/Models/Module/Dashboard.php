<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Dashboard extends Model
{

    public static function getHardware(){

        $sql = "
        SELECT
        COALESCE(SUM(CASE WHEN type = 'trolley' THEN 1 ELSE 0 END),0) AS trolley, 
        COALESCE(SUM(CASE WHEN type = 'line' THEN 1 ELSE 0 END),0) AS line
        FROM hardwares
        WHERE deleted_at IS NULL;
        ";
        return DB::select( DB::raw($sql));
    }


    public static function getEntity($year = null, $device_id = null){

        if(isAdministrator()){
            $where = ' WHERE EXTRACT(YEAR from created_at) ='. $year;
        }else{
            $where = ' WHERE EXTRACT(YEAR from created_at) ='. $year;
        } 
        
        if($device_id != null){
            $where .= ' AND line ="'.$device_id.'"';
        }  
        $sql = "
        SELECT
        COALESCE(SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END),0) AS open, 
        COALESCE(SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END),0) AS closed
        FROM data_logs 
        $where
        ";
        return DB::select( DB::raw($sql));
    }


    public static function getByCategory($year = null)
    {  
        $sql = "SELECT t1.name, t2.num
        FROM categories t1 
        LEFT JOIN (
                SELECT category_id, count(id) As num
                FROM data_logs 
                WHERE EXTRACT(YEAR from created_at) = $year
                GROUP BY category_id
            ) t2 ON t1.id = t2.category_id
        WHERE deleted_at is NULL";

        return DB::select( DB::raw($sql));
    }


    public static function getByArea($year = null)
    {  
        $sql = "SELECT t1.name, t2.num
        FROM areas t1 
        LEFT JOIN (
                SELECT hardwares.area_id, count(data_logs.id) As num
                FROM data_logs
                LEFT JOIN hardwares ON data_logs.line = hardwares.device_id
                WHERE EXTRACT(YEAR from data_logs.created_at) = $year
                GROUP BY hardwares.area_id
            ) t2 ON t1.id = t2.area_id
       ";

        return DB::select( DB::raw($sql));
    }


    public static function getByDay($year){
        $sql ="
            SELECT  DATE(created_at) Date, COUNT(id) totalCOunt
            FROM   data_logs
            GROUP BY  DATE(created_at)
        ";

        return DB::select( DB::raw($sql));

    }
 
}
