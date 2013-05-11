<?php

class Arrays {

	static public function implode($glue, $array) {
		if (is_null($array)) {
			return '';
		}
		if (!is_array($array)) {
			$array = array($array);
		}

		return implode($glue, $array);
	}

	static public function array_pluck($array, $key)
	{
	    if (is_array($key) || !is_array($array)) return array();
	    $funct = create_function('$e', 'return is_array($e) && array_key_exists("'.$key.'",$e) ? $e["'. $key .'"] : null;');
	    return array_map($funct, $array);
	}	

}