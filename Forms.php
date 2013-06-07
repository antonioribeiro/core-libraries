<?

class Forms extends Form {

	/*public static function attributeValue($name, $value = null)
	{
		$method = new \ReflectionMethod(App::make('form'), 'getValueAttribute');
		$method->setAccessible(true);

		return $method->invoke(App::make('form'), $name, $value);
	}    

    protected function makePublic($obj, $property)
    {
        $reflect = new \ReflectionObject($obj);
        $property = $reflect->getProperty($property);
        $property->setAccessible(true);
 
        return $property;
    }

	public static function WORKAROUND_getValueAttribute($name, $value = null) {
		$dom = new DOMDocument();
		$dom->loadHTML( '<html><body>'.Form::text($name, $value).'</body></html>' );

		return $dom->getElementsByTagName('input')->item(0)->getAttribute('value');
	}

	/**
	 * Get the action for an "action" option.
	 *
	 * @param  array|string  $options
	 * @return string
	 *
	protected function getControllerAction($options)
	{
		if (is_array($options))
		{
			return $this->url->action($options[0], array_slice($options, 1));
		}

		if (is_null($action = $this->url->action($options)) and $this->url->isValidUrl($options)) {
			$action = $options;
		}

		return $action;
	}

src/Illuminate/Database/Eloquent/Model.php
src/Illuminate/Html/FormBuilder.php
src/Illuminate/Routing/Router.php
src/Illuminate/Validation/Validator.php

	*/

}
