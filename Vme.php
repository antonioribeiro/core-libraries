<?php

class Vme {
	
	private $secret = 0;
	private $amount = 0;
	private $currency = 'R$';
	private $product_id = '';

	public function __construct($secret, $amount, $product_id, $currency = 'R$')
	{
		$this->secret = $secret;
		$this->amount = $amount;
		$this->currency = $currency;
		$this->product_id = $product_id;
	}

	
}