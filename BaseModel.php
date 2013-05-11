<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class BaseModel extends Eloquent {

	public $errors;

	protected $columns;

	public function __construct(array $attributes = array()) {
		$this->guarded = array_merge($this->guarded, array('btnSubmit', 'btnCancel', 'btnDelete'));

		parent::__construct($attributes);
	}

	public static function boot() {
		parent::boot();

		static::saving(function ($data) {
			// this is silly, but I'm having to remove the request path from the list of attributes
			// 

			foreach($data->attributes as $key => $value) {
				if(!in_array($key, $data->getColumns())) {
					Log::error("BaseModel: $key not found on table $data->table");
					unset($data->attributes[$key]);
				} else {
					if(!$value) {
						$data->attributes[$key] = null; /// we will store null for all of our unset data
					}
				}
			}

			return $data->validate();
		});
	}

	public function validate() {

		$validation = Validator::make($this->attributes, $this->rules);

		if($validation->passes()) return true;

		$this->errors = $validation->messages();

		return false;

	}

	public function getColumns($tableName = null) 
	{
		if(!isset($this->columns)) {
			$this->columns = DB::table('information_schema.columns')
								->select('column_name')
								->where('table_name', $tableName ?: $this->getTable())
								->get();

			foreach($this->columns as $key => $value)
			{
				$this->columns[$key] = $value->column_name;
			}			

			$this->columns = array_reverse($this->columns);
		}

		return $this->columns;
	}

	public static function getIcon() 
	{
		return static::$icon;
	}

}