<?php 

class Widget {

	static public function contentHeader($header, $icon = null, $tools = null, $controls = null, $tags = null) {
		if(!is_array($header)) {
			$headers['header'] = $header;
		} else {
			$headers['header'] = $header[0];
			unset($header[0]);
			if(count($header) > 0) {
				$headers['subHeaders'] = $header;
			}
		}

		return View::make('site._partials.contentHeader')
						->with('bladeData', ['contentHeader' => $headers, 'contentHeaderTags' => $tags, 'contentHeaderIcon' => $icon, 'contentHeaderTools' => $tools, 'contentHeaderControls' => $controls]);
	}

	//// ----------- renderForm
	
	static public function renderForm($view, $variables = null) {
		return View::make('templates.'.Config::get('app.template').'._partials.renderForm')
						->with('bladeData', ['view' => $view, 'variables' => $variables]);
	}

	//// ----------- flatBox
	
	static public function flatBox($caption, $contents) {
		return View::make('templates.'.Config::get('app.template').'._partials.flatBox')
						->with('bladeData', ['caption' => $caption, 'contents' => $contents]);
	}

	//// ----------- Box

	static public function boxToolsOpen() {
		return View::make('templates.'.Config::get('app.template').'._partials.boxToolsOpen')
						.'<!--box tools-->';
	}

	static public function boxToolsClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.boxToolsClose')
						.'<!--/box tools-->';
	}

	static public function boxToolButton($action, $hint, $iconClasses, $extraTags = null) {
		if(is_array($extraTags))
		{
			$r = '';
			foreach($extraTags as $key => $tag) {
				$r .= "$key=\"$tag\" ";
			}
			$extraTags = $r;
		}

		return View::make('templates.'.Config::get('app.template').'._partials.boxToolsButton')
						->with('bladeData', ['action' => $action, 'hint' => $hint, 'iconClasses' => $iconClasses, 'extraTags' => $extraTags])
						.'<!--box tools-->';

		return 	"<a class=\"btn $btnClasses\" data-original-title=\"$hint\" href=\"$action\">
					<i class=\"$iconClasses\"></i>
				</a>";
	}

	static public function popupModalButton($action, $hint, $iconClasses, $btnClasses = 'btn-small') {
		return Widget::boxToolButton($action, $hint, $iconClasses, 'data-toggle="modal"');
	}

	static public function boxOpen($span = 12) {
		return View::make('templates.'.Config::get('app.template').'._partials.boxOpen')
						->with('bladeData', ['span' => $span])
						.'<!--/box body-->';
	}

	static public function boxClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.boxClose').'<!--/box body-->';
	}

	static public function boxHeaderOpen($caption = null) {
		return View::make('templates.'.Config::get('app.template').'._partials.boxHeaderOpen')
						->with('bladeData', ['caption' => $caption])
						.'<!--/box header-->';
	}

	static public function boxHeaderClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.boxHeaderClose')
						.'<!--/box header-->';
	}

	static public function boxBodyOpen($caption = null) {
		return View::make('templates.'.Config::get('app.template').'._partials.boxBodyOpen')
						->with('bladeData', ['caption' => $caption])
						.'<!--/box body-->';
	}

	static public function boxBodyClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.boxBodyClose')
						.'<!--/box body-->';
	}

	//// ----------- Table

	static public function tableMasterHeaderOpen($header, $additionalTags = null) {
		return View::make('templates.'.Config::get('app.template').'._partials.tableMasterHeaderOpen')
						->with('bladeData', ['header' => $header, 'additionalTags' => $additionalTags]);

	}
	static public function tableMasterHeaderClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.tableMasterHeaderClose');

	}

	static public function tableOpen($additionalTags = null) {
		return View::make('templates.'.Config::get('app.template').'._partials.tableOpen')
						->with('bladeData', ['additionalTags' => $additionalTags]);
	}

	static public function tableClose() {
		return View::make('templates.'.Config::get('app.template').'._partials.tableClose');
	}

	static public function tableBodyOpen() {
		return '<!--table body-->
					<tbody>';
	}

	static public function tableBodyClose() {
		return '	</tbody>
				<!--/table body-->';
	}

	static public function tableHeaderOpen() {
		return '<thead>';
	}

	static public function tableHeaderClose() {
		return '	</thead>
				<!--/table header-->';
	}

	static public function tableHeaderColumns($captions) {
		$header = '<!--table header items--><tr>';

		foreach($captions as $caption => $size) {
			$header .= '<th style="width:'.$size.'"  class="left">
							'.$caption.'
						</th>';
		}
												
		$header .= '</tr><!--/table header items-->';

		return $header;
	}

	static public function tableBodyRows($rowsLinks, $model, $columns, $filter) {

		$tables = explode(',', $model);

		$rows = new $tables[0];
		unset($tables[0]); /// remove model name

		$tableName = $rows->getTable();

		if(!empty($filter)) {
			$rows = $rows->distinct();

			foreach($tables as $join) {
				list($table, $first, $operator, $second) = explode(':',$join);
				$rows = $rows->join($table, $first, $operator, $second, 'left');
			}

			foreach(explode(',', $filter) as $expression) {
				$fields = explode(':', $expression);
				if($fields[1] == 'in') {
					if(empty($fields[2])) {
						$rows = $rows->whereIn($fields[0],array(-1));
					} else {
						$rows = $rows->whereIn($fields[0],explode('|',$fields[2]));
					}
				} else {
					$rows = $rows->where($fields[0],$fields[1],$fields[2]);
					$rows = $rows->orWhere(function($query) use ($fields)  {
                						$query->whereNull($fields[0]);
            					});
				}
				
			}

			$rows = $rows->get( array($tableName.'.*') );
		} else {
			$rows = $model::all( array($tableName.'.*') );
		}

		// column:Nome:17%:name,column:E-mail:17%:email,method:Endereço:*:addressFull(),column:Telefones:17%:telephones,icons:Ações:17%|icon:Editar::#:icon-pencil|icon:Imprimir ficha::#:icon-print|icon:Deletar::#:icon-trash
		$columns = explode(',', $columns);

		$result = '';

//Office|OfficeAddress:office_id|

		foreach($rows as $key => $row) {
			$result .= '<tr name="clickable_row" style="cursor:pointer;" id="id_'.$row->id.'" href="'.Widget::formatDisplay(0, $rowsLinks, $row).'">';
			foreach($columns as $key => $column) {
				$fields = explode('|', $column);
				$parts = explode(':', $fields[0]);
				$class = isset($parts[6]) ? ' class = "'.$parts[6].'"' : '';
				if ($parts[0] == 'icons') {
					$class = ' class = "'.$parts[4].'"';
				}

				$result .= '<td '.$class.'>';
				foreach($fields as $key => $field) {
					$parts = explode(':', $field);

					if ($parts[0] != 'icons') {
						$class = '';
						if (isset($parts[4]) and !empty($parts[4])) {
							$class = ' class = "'.$parts[4].'"';
						}

						switch ($parts[0]) {
							case 'icon':
								$value = '	<a class="" data-original-title="'.$parts[1].'" href="'.Widget::formatDisplay($value, $parts[3], $row).'">
												<i '.$class.'></i>
											</a>';

								break;

							case 'column':
								$value = $row->{$parts[3]};

								break;

							case 'method':
								$value = $row->$parts[3]();

								break;

						}

						if(isset($parts[5]) and !empty($parts[5])) {
							$value = Widget::formatDisplay($value, $parts[5], $row);
						}
						
						$result .= $value;
					}
				}
				$result .= '</td>';
			}
			$result .= '</tr>';
		}

		return $result;
	}
 
	static private function formatDisplay($value, $format, $data) {
		$parts = explode('+',$format);

		if(isset($parts[0]) and !empty($parts[0])) {
			$class = $parts[0];
		} else {
			$class = '';
		}

		if(isset($parts[1]) and !empty($parts[1])) {
			$method = $parts[1];
		} else {
			$method = '';
		}

		if(isset($parts[2]) and !empty($parts[2])) {
			$parameters = $parts[2];
		} else {
			$parameters = '';
		}
		
		switch ($class) {
			case 'Mailto':
				return "<a href=\"mailto:$value\">$value</a>";

				break;
			
			case 'ahref':
				return Widget::formatURL($value, $method, $parameters, $data);

				break;

			case 'URL':
				return Widget::buildURL($value, $method, $parameters, $data);

				break;

			default:
				return 'invalid format: '.$format;

				break;
		}
	}

	static private function buildURL($value, $method, $parameters, $data) {
		if(preg_match_all('/{([^}]*)}/', $parameters, $matches)) {

			foreach($matches[1] as $var) {
				$parameters = preg_replace('/\{'.$var.'\}/', $data->{$var}, $parameters);
			}

		}

		return call_user_func('URL::'.$method, $parameters);
	}

	static private function formatURL($value, $method, $parameters, $data) {
		return '<a href="'.Widget::buildURL($value, $method, $parameters, $data).'">'.$value.'</a>';
	}
	
	static function popupOpen($name, $title, $subTitle = '') {

		return View::make('widgets.popup.open')
			->with('name', $name)
			->with('title', $title)
			->with('subTitle', $subTitle);

	}

	static public function popupClose() {

		return View::make('widgets.popup.close');

	}

	static public function popupAddButtons($buttons) {

		return View::make('widgets.popup.addButtons')
				->with('buttons', $buttons);

	}

	static public function input($column, $caption, $inputs)
	{
		$r = '<div class="control-group">';
		
		if(!empty($caption)) {
			$r .= Forms::label($column, $caption, array('class'=>'control-label'));
		}
				
		$r .= '<div class="controls">'
					.Widget::generateInputs($inputs)
				.'</div>'
			.'</div>';

		return 	$r;
	}

	static public function generateInputs($inputs) 
	{
		$r = '';
		
		foreach($inputs as $line) {
			if(!empty($line['disabled'])) {
				$line['options']['disabled'] = 'disabled';
				$line['options']['placeholder'] = '';
			}

			if ($line['icon']) {
				list($iconType, $iconId, $iconImage) = $line['icon'];
			} else {
				list($iconType, $iconId, $iconImage) = [null,null,null];
			}

			$r .= $iconType ? '<div class="input-'.$iconType.'">' : '';

			if ($line['type'] == 'select') {
				$r .= Form::select($line['column'], $line['value'], null,  $line['options']);
			} else if ($line['type'] == 'password') {
				$r .= Form::password($line['column'], $line['options']);	
			} else {
				$r .= Form::$line['type']($line['column'], isset($line['value']) ? $line['value'] : null, $line['options']);	
			}
			
			if($iconImage) {
				$iconImage = '<i class="'.$iconImage.'"></i>';
			}

			$r .= "\n";

			$r .= $iconType ? '<span class="add-on" id="addon-'.$line['column'].'">'.$iconImage.'</span></div>' : '';
		}

		return $r;
	}

	static public function section($caption, $icon = null) 
	{
		return View::make('templates.'.Config::get('app.template').'._partials.sectionHeader')
						->with('bladeData', ['sectionHeader' => $caption, 'sectionHeaderIcon' => $icon]);
	}

 	static public function menuItem($url, $caption, $icon, $activeItem) {

		return View::make('templates.'.Config::get('app.template').'._partials.menuItem')
						->with('bladeData', ['url' => $url, 'caption' => $caption, 'icon' => $icon, 'activeItem' => Session::get('currentMenu') == $activeItem ? 'class="active"' : '' ]);

	}

	static public function button($class, $buttons)
	{
		$buttons = Widget::generateButtons($buttons);

		return View::make('templates.'.Config::get('app.template').'._partials.buttonWrapper')
						->with('bladeData', compact('class', 'buttons'));
	}

	static public function generateButtons($buttons)
	{
		$r = '';
		
		foreach($buttons as $button) 
		{
			if(isset($button) and $button)
			{
				$r .= View::make('templates.'.Config::get('app.template').'._partials.button')
						->with('bladeData', $button);
			}
		}

		return $r;
	}

}