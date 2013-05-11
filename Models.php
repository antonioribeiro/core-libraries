<?php

class Models {

	static public function pushInput($model, $column, $canBeEmpty = false) {
		if(Input::has($column)) {
			$model->{$column} = Input::get($column);
		} else if ($canBeEmpty) {
			$model->{$column} = '';
		}
	}

}