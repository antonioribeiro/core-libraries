<?php

class Template {

	static public function sessionFlashMessages($type = 'bootstrap') {

		if( $value = SessionClass::getValue('flashMessages') ) {
			return Template::flashMessage($value, true, $type);
		}
	
		if( $value = SessionClass::getValue('flashMessage') ) {
			return Template::flashMessage($value, true, $type);
		}

	}

	static public function flashMessages($messages, $canClose = true, $type = 'bootstrap') {
		if (!isset($messages) or empty($messages)) {
			return '';
		}

		return Template::flashMessage($messages, true, $type);
	}

	static public function flashMessage($message, $canClose = true, $type = 'bootstrap') {
		$message = explode('|', $message);
		if(count($message) == 1) {
			$kind = 'error';
			$message = $message[0];
		} else {
			$kind = $message[0];
			$message = $message[1];
		}

		if ($type == 'bootstrap') {
			return View::make('site._partials.notification')
						->with('kind', $kind)
						->with('canClose', $canClose)
						->with('message', $message);
		} else {
			return "notification('$kind','$message')";
		}
	}

	static public function alertMessage($title, $message, $kind = 'error') {
		return View::make('site._partials.notification')
					->with('title', $title)
					->with('canClose', true)
					->with('message', $message)
					->with('kind', $kind);
	}


	static public function validationMessages($messages, $kind = 'error') {
		$return = '';

		foreach ($messages->all() as $message)
		{
		    $return .= View::make('site._partials.notification')
							->with('message', $message)
							->with('canClose', true)
							->with('kind', $kind);
		}		

		return $return;
	}

}
