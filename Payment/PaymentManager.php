<?php

class PaymentManager implements PaymentGatewayInterface {

	protected $gateway;

	public function __construct(PaymentGatewayInterface $gateway)
	{
		$this->gateway = $gateway;
	}	
	
	public function pay()
	{
		return $this->gateway->pay();
	}

	public function processNotification($notification)
	{
		return $this->gateway->processNotification($notification);
	}

	public function getPaymentStyle()
	{
		return $this->gateway->getPaymentStyle();
	}

	public function getPaymentData()
	{
		return $this->gateway->getPaymentData();
	}

}