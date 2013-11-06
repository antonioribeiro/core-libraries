<?php

class BaseModel extends \Eloquent {

	public $errors;

	private static $safeColumns = ['password_confirmation'];

	protected $columns;

    protected $guarded = array();

    public $rules = array();

	public function __construct(array $attributes = array()) {
		$this->guarded = array_merge($this->guarded, array('btnSubmit', 'btnCancel', 'btnDelete'));

		parent::__construct($attributes);
	}

	public static function boot() {
		parent::boot();

		static::saving(function ($data) {
			$data->attributes = BaseModel::removeNonAttributesFromList($data->attributes, $data);

			return $data->validate();
		});
	}

	public function save(array $options = []) {
		if ( parent::save() )
		{
			$this->afterSave();
			return true;
		}
		else
		{
			return false;	
		}
	}

	public function afterSave() {}

	public static function removeNonAttributesFromList($attributes, $model) {
		// This is silly, I know, but I'm having to remove the request path from the list of attributes and some attributes that may appear on Input but are not part of the Model attributes

		if (is_string($model)) $model = new $model;

		foreach($attributes as $key => $value) {
			if (!in_array($key, $model->getColumns()) and !in_array($key, static::$safeColumns)) {
				Log::error("BaseModel (removeNonAttributesFromList): $key not found on table $model->table");
				unset($attributes[$key]);
			} else {
				if ($value === 'false'){
					$attributes[$key] = false;
				}
				elseif (!$value and $value !== false and $value !== 0) 
				{
					$attributes[$key] = null; /// we will store null for all of our unset data
				}
			}
		}
		
		return $attributes;		
	}

	public function validate() {

		$validation = Validator::make($this->attributes, $this->rules);

		if ($validation->passes()) return true;

		$this->errors = $validation->messages();

		return false;

	}

	public function getColumns($tableName = null) 
	{
		if (!isset($this->columns)) {
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

	public function getRowsOrModel()
	{
		$return = isset($this->getAllRows) ? call_user_func(get_class($this).'::'.$this->getAllRows) : get_class($this);
		
		return $return;
	}

	public function syncFormChilds($inputs)
	{
		foreach($this->formFields as $key => $field)
		{
			foreach($field['inputs'] as $key2 => $input)
			{
				if (isset($input['childs']))
				{
					$method = $input['childs'];
					$formField = str_replace('[]', '', $input['column']);

					$this->$method()->sync($inputs[$formField]);
				}
			}
		}
	}

	public function getSafeColumns()
	{
		return $this->safeColumns();
	}

	public function toJsonCamel()
	{
		$array = $this->toArray();

		foreach($array as $key => $value)
		{
			$return[camel_case($key)] = $value;
		}

		return $return;
	}

	public function getRoute()
	{
		return $this->route;
	}

}