<?

class SessionClass {

	static public function storeURL($url) {
		if(Session::has('stored_urls')) {
			$urls = Session::get('stored_urls');
		} else {
			$urls = array();
		}

		$urls[] = $url;

		Session::put('stored_urls', $urls);
	}

	static public function getValue($name) {

		if (Session::has($name)) {
			$value = Session::get($name);

			return $value;
		}

	}

}
