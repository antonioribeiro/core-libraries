<?php

class BladeData {

	protected $data;

	public static function put($var, $value)
	{
		$blade = static::getBladeData();

		$blade->data[$var] = $value;
	}

	public static function get($var)
	{
		$blade = static::getBladeData();

		return isset($blade->data[$var]) ? $blade->data[$var] : null;
	}

	public static function getBladeData()
	{
		$blade = App::make('bladeData');

		if ( $blade->data == NULL )
		{
			$blade->data = [];
		}

		return $blade;
	}

	public static function all()
	{
		return static::getBladeData();
	}

	public static function produceFormData($model, $disabled, $readonly, $parent_id = null)
	{
		BladeData::put('model', $model);
		BladeData::put('disabled', $disabled);
		BladeData::put('readonly', $readonly);

		if (isset($parent_id))
		{
			BladeData::put('parent_id', $parent_id);
		}

		BladeData::put('modelCaption', BladeData::get('model')->caption);
		BladeData::put('mainRoute', BladeData::get('model')->getRoute());
		BladeData::put('rootRoute', "/".BladeData::get('mainRoute'));
		BladeData::put('formName', BladeData::get('mainRoute').'Form');
		BladeData::put('modelClass', BladeData::get('model')->class);
		BladeData::put('storeRoute', BladeData::get('mainRoute').".store");
		BladeData::put('updateRoute', BladeData::get('mainRoute').".update");
		BladeData::put('updateUrl', BladeData::get('rootRoute').'/update/'.(BladeData::get('model')->id ? BladeData::get('model')->id : 0));
		BladeData::put('header', BladeData::get('model')->id !== NULL ? HTML::linkRoute(BladeData::get('mainRoute').'.show', BladeData::get('model')->name, BladeData::get('model')->id) : 'Nova '.BladeData::get('modelCaption'));

		BladeData::put('parentRoute', BladeData::get('mainRoute'));
		BladeData::put('parentmodel', null);

		if (BladeData::get('model')->id !== NULL) {
			BladeData::put('editUrl', URL::route(BladeData::get('mainRoute').'.edit',BladeData::get('model')->id));
			BladeData::put('updateUrl', BladeData::get('rootRoute').'/update/'.(BladeData::get('model')->id ? BladeData::get('model')->id : 0));
			BladeData::put('deleteUrl', URL::route(BladeData::get('mainRoute').'.destroy',BladeData::get('model')->id));
			BladeData::put('showUrl', URL::route(BladeData::get('mainRoute').'.show',BladeData::get('model')->id));
		}

		if (BladeData::get('parentmodel')) {
			BladeData::put('indexUrl', URL::route(BladeData::get('parentRoute').'.show', BladeData::get('parentModel')));
		} else {
			BladeData::put('indexUrl', URL::route(BladeData::get('parentRoute').'.index'));
		}

		BladeData::put('validateFirstAPIUrl', URL::to('api/validate/'.BladeData::get('model')->class));		
	}

	public static function produceUserAddresses($user, $disabled, $enabled)
	{
		$addresses = $user->addresses->toArray();

		if ( !$disabled)
		{
			foreach((new UserAddress)->getColumns() as $column)
			{
				$address[$column] = '';
			}

			unset($address['created_at']);
			unset($address['updated_at']);

			$address['id'] = 0; /// will be included if filled

			$addresses[] = $address;
		}

		$user->fill(['address' => $addresses]);

		BladeData::put('user-addresses', $addresses);

		return $user;
	}

}