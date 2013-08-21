<?php

use Omnipay\Common\GatewayFactory;

class PayPal implements PaymentGatewayInterface {

	protected $paymentData;

	public function __construct(array $paymentData)
	{
		$this->paymentData = $paymentData;
	}

	public function pay()
	{
		// $gateway = GatewayFactory::create('PayPal_Express');
		// $gateway->setUsername('antoniocarlos@cys.com.br');
		// $gateway->setPassword('9145mcbpal');
		// $gateway->setTestMode(true);
		// $gateway->setSolutionType = 'Sole';
		// $gateway->setLandingPage = 'Login'
		// $gateway->setSignature
		// $gateway->setHeaderImageUrl = '';

		// $response = $gateway->purchase(['amount' => '0.99', 'currency' => 'BRL'])->send();

		// if ($response->isSuccessful()) {
		//     // payment was successful: update database
		//     print_r($response);
		// } elseif ($response->isRedirect()) {
		//     // redirect to offsite payment gateway
		//     $response->redirect();
		// } else {
		//     // payment failed: display message to customer
		//     echo $response->getMessage();
		// }

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