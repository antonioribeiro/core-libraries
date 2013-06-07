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
			if ($file=="db.php")continue; // the db object 
			$trace.=str_repeat("&nbsp;",++$sp); //spaces(++$sp); 
			$trace.="file=$file, line=$line, function=$function<br>";        
		} 

		echo "$trace";

		if ($die) die;
	} 

	public static function queryLog()
	{
		dd( DB::getQueryLog() );

		/// from Taylor: DB::listen(function($sql) { var_dump($sql); });
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

	public static function arrayValueReplace($maybe_array, $replace_from, $replace_to) {

		if (!empty($maybe_array)) {
			if (is_array($maybe_array)) {
				foreach ($maybe_array as $key => $value) {
					$maybe_array[$key] = self::arrayValueReplace($value, $replace_from, $replace_to);
				}
			} else {
				if (is_string($maybe_array)){
					$maybe_array = str_replace($replace_from, $replace_to, $maybe_array);
				}               
			}
		}

		return $maybe_array;
	}


	public static function  strBaseConvert($str, $frombase=10, $tobase=36) { 
		$str = trim($str); 
		if (intval($frombase) != 10) { 
			$len = strlen($str); 
			$q = 0; 
			for ($i=0; $i<$len; $i++) { 
				$r = base_convert($str[$i], $frombase, 10); 
				$q = bcadd(bcmul($q, $frombase), $r); 
			} 
		} 
		else $q = $str; 
	  
		if (intval($tobase) != 10) { 
			$s = ''; 
			while (bccomp($q, '0', 0) > 0) { 
				$r = intval(bcmod($q, $tobase)); 
				$s = base_convert($r, 10, $tobase) . $s; 
				$q = bcdiv($q, $tobase, 0); 
			} 
		} 
		else $s = $q; 
	  
		return $s; 
	}     

	public static function toBase36($base10)
	{
		return strtolower(strBaseConvert($base10, 10, 36));
	}

	public static function toBase10($base36)
	{
		return strBaseConvert($base36, 36, 10);
	}    

	public static function formatMoney($value)
	{
		return 'R$ '.static::formatDecimalBR($value, 2);
	}    

	public static function formatDecimalBR($value, $decimals = 2)
	{
		return number_format ( $value , $decimals, ',' , '.' );
	}

	public static function formatDecimal($value, $decimals = 2)
	{
		return number_format ( $value , $decimals, '.' , ',' );
	}

	public static function recursiveUnset(&$array, $unwanted_key) {
		if (!is_array($array) || empty($unwanted_key)) 
			 return false;

		unset($array[$unwanted_key]);

		foreach ($array as &$value) {
			if (is_array($value)) {
				static::recursiveUnset($value, $unwanted_key);
			}
		}
	}

	public static function XML2Array ( $xml , $recursive = false )
	{
		if ( ! $recursive )
		{
			$array = simplexml_load_string ( $xml ) ;
		}
		else
		{
			$array = $xml ;
		}
		
		$newArray = array () ;
		$array = ( array ) $array ;
		foreach ( $array as $key => $value )
		{
			$value = ( array ) $value ;
			if ( isset ( $value [ 0 ] ) )
			{
				$newArray [ $key ] = trim ( $value [ 0 ] ) ;
			}
			else
			{
				$newArray [ $key ] = static::XML2Array ( $value , true ) ;
			}
		}
		return $newArray ;
	}

}
