<?php

class Authentication {

	static public function validate($login, $password) {
		return Auth::validate( Authentication::makeCredentials($login,$password) );
	}

	static public function attempt($login, $password) {
		return Auth::attempt( Authentication::makeCredentials($login,$password) );
	}

	static public function login(UserInterface $user, $remember = false) {
		return Auth::login($user, $remember);
	}

	static public function logout() {
		return Auth::logout();	
	}

	static public function check()
	{
		return Auth::check();
	}

	static public function guest()
	{
		return Auth::guest();
	}

	static public function user()
	{
		return Auth::user();
	}

	static public function makeCredentials($login,$password) {
		return array(
			'email' => $login,
			'password' => $password,
		);
	}

}