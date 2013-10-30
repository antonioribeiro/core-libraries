<?

class Producer {

	public static function password($length = 8) {
		return Str::random($length);
	}


	public static function monthDays($firstItem = array()) {

		if (isset($firstItem)) {
			$return[0] = $firstItem;
		}

		foreach(explode('|', '1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31')
					as $key => $value) {

			$return[$value] = $value;
		}

		return $return;

	}
	
	public static function months($firstItem) {
		if (isset($firstItem)) {
			$return[] = $firstItem;
		}

		foreach(array(1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro')
					as $key => $value) {

			$return[$key] = $value;
		}

		return $return;
	}

	public static function years($firstItem) {
		if (isset($firstItem)) {
			$return[] = $firstItem;
		}

		for($x = 2014; $x>1899; $x--) {
			$return[$x] = $x;
		}

		return $return;
	}

	public static function states($firstItem, $mustBeInModel = null, $mustBeInColumn = null) {

		if (isset($firstItem)) {
			$return[] = $firstItem;
		}

		$states = new State;

		if (isset($mustBeInModel)) {
			$values = $mustBeInModel::distinct()->get(array($mustBeInColumn))->toArray();

			$search = array();
			foreach($values as $records) {
				foreach($records as $key => $value) {
					$search[] = $value;
				}
			}

			if (count($search) > 0) {
				$states = $states->whereIn('id',$search);	
			}
			
		}

		return Producer::generateArray($states->orderBy('name')->get(array('id','name')), $firstItem, 'id', 'name', 'id');

	}

	public static function cities($firstItem, $stateID = 'RJ') {

		return Producer::generateArray(City::where('country_id','BR')->where('state_id',$stateID)->orderBy('name')->get(array('id','name')), $firstItem, 'id', 'name');

	}

	public static function genders($firstItem) {

		return Producer::generateArray(Gender::whereNotNull('id')->orderBy('name')->get(), $firstItem, 'id', 'name');

	}

	public static function maritalStatuses($firstItem) {

		return Producer::generateArray(MaritalStatus::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function generateArray($data, $firstItem, $id, $name, $abbreviation = null) 
	{

		$r = array();

		if (!empty($firstItem)) {
			$r[""] = $firstItem;
		}

		$p = strpos($name, '()');
		if ($p === false) {
			$method = false;
		} else {
			$method = true;
			$name = str_replace('()', '', $name);
		}

		foreach($data as $key => $row) {
			$r[$row->$id] = ($abbreviation ? $row->$abbreviation.' - ' : ''). ($method ? $row->$name() : $row->$name);
		}

		return $r;

	}

	public static function relationships($firstItem) {

		return Producer::generateArray(Relationship::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function model($model, $displayColumn, $filters, $firstItem) {

		if (isset($firstItem)) {
			$return[] = $firstItem;
		}

		$instance = new $model;

		foreach($filters as $filter) {
			list($column, $operand, $value) = $filter;
			$instance = $instance->where($column, $operand, $value);
		}

		return Producer::generateArray($instance->get(), $firstItem, 'id', $displayColumn);

	}

	public static function userGroups($firstItem) {

		return Producer::generateArray(Group::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function categories($firstItem) {

		$categories = Category::hierarchicalCategoryList();

		return Producer::generateArray($categories, $firstItem, 'id', 'name');

	}

	public static function brands($firstItem) {

		return Producer::generateArray(Brand::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function units($firstItem) {

		return Producer::generateArray(Unit::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function seasons($firstItem) {

		return Producer::generateArray(Season::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function agesGroups($firstItem) {

		return Producer::generateArray(AgeGroup::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function sizes($firstItem) {

		return Producer::generateArray(Size::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}	

	public static function colors($firstItem) {

		return Producer::generateArray(Color::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}	

	public static function sizesGroups($firstItem) {

		return Producer::generateArray(SizeGroup::whereNotNull('id')->orderBy('id')->get(), $firstItem, 'id', 'name');

	}

	public static function cieloCardBrands($firstItem) {

		return Producer::generateArray(
											PaymentOption::where('payment_service_id', PaymentService::where('name', 'Cielo')->first()->id)->get()
											, $firstItem
											, 'id'
											, 'name'
										);

	}

}
