<?php

class Paypal implements PaymentGatewayInterface {

	protected $paymentData;

	public function __construct(array $paymentData)
	{
		$this->paymentData = $paymentData;
	}

	public function pay()
	{
		return 'paid';
	}

	public function processNotification($notification)
	{
		return 'notified';
	}

	public function getPaymentStyle()
	{
		return 'url';
	}

	public function getPaymentData()
	{
		return $this->paymentData;
	}

}