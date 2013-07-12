<?php

class LDAP {

	public static function getLdapRdn($username)
	{
		return str_replace('[username]', $username, 'CN=[username],' . Config::get('app.ldap_tree'));
	}

	public static function authenticate($username, $password)
	{
		$ldapRdn = static::getLdapRdn($username);

		Log::info($ldapRdn);

		$ldapconn = ldap_connect( Config::get('app.ldap_server') ) or die("Could not connect to LDAP server.");
		$result = false;

		if ($ldapconn) 
		{
			$ldapbind = @ldap_bind($ldapconn, $ldapRdn, $password);

			if ($ldapbind) 
			{
				$result = true;
			} else {
				Log::error('Error binding to LDAP.');
			}

			ldap_unbind($ldapconn);

		} else {
			Log::error('Error connecting to LDAP.');
		}

		return $result;

	}

	public static function searchUser($username)
	{
		$ldapRdn = static::getLdapRdn( Config::get('app.ldap_user') );

		Log::info($ldapRdn);

		$ldapconn = ldap_connect( Config::get('app.ldap_server') ) or die("Could not connect to LDAP server.");
		$result = false;

		if ($ldapconn) 
		{
			$ldapbind = @ldap_bind($ldapconn, $ldapRdn, Config::get('app.ldap_password'));

			if ($ldapbind) 
			{
				$result = true;
			} else {
				Log::error('Error binding to LDAP.');
			}

			$result = ldap_search($ldapconn, Config::get('app.ldap_tree'), "(CN=$username)");

			if (! empty($result))
			{
				return ldap_get_entries($ldapconn, $result);	
			}

		} else {
			Log::error('Error connecting to LDAP.');
		}

		return false;

	}

}
