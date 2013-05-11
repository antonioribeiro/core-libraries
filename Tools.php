<?php 
// var_format 

use Carbon\Carbon;

Class Tools {


    public static function varFormat($v) // pretty-print var_export 
    { 
        return (str_replace(array("\n"," ","array"), array("<br>","&nbsp;","&nbsp;<i>array</i>"), var_export($v,true))."<br>"); 
    } 

    public static function trace($die = false)
    { 
        $bt=debug_backtrace();
        $sp=0;
        $trace="";

        foreach($bt as $k=>$v) 
        { 
            extract($v); 
            $file=substr($file,1+strrpos($file,"/")); 
            if($file=="db.php")continue; // the db object 
            $trace.=str_repeat("&nbsp;",++$sp); //spaces(++$sp); 
            $trace.="file=$file, line=$line, function=$function<br>";        
        } 

        echo "$trace";

        if($die) die;
    } 

    public static function queryLog()
    {
        dd( DB::getQueryLog() );
    }

    public static function string2Date($date)
    {
        if (!isset($date) or !$date) return null;

        $d = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        return "$d";
    }

    public static function date2String($date)
    {
        if (!isset($date) or !$date) return null;

        $d = Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');

        return "$d";
    }

}
