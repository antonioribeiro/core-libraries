<?php namespace Payment;

use \Config;

class PaymentConfiguration {

	public $environment = 'teste';
	public $returnUrl = 'http://www.google.com';
	public $merchantId;
	public $merchantKey;

	public function __construct()
	{

	    $this->merchantId = Config::get('app.cielo.merchantId');
	    $this->merchantKey = Config::get('app.cielo.merchantKey');

	}	

}