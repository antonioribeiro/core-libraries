<?php

require_once __DIR__."/../../vendor/pagseguro/source/PagSeguroLibrary/PagSeguroLibrary.php";

class PagSeguro {

	private $paymentData;

	public function __construct($data = null)
	{
		$this->setOrder($data);
	}
	
	public function setOrder($data)
	{
		$this->paymentData = $data;
	}

	public static function credentials()
	{
		return new PagSeguroAccountCredentials(  
												Config::get('app.pagseguro.email'),   
												Config::get('app.pagseguro.token')  
											);		
	}

	public static function getNotification($notificationCode)  
	{
		return PagSeguroNotificationService::checkTransaction(static::credentials(), $notificationCode);
	}

	public static function getTransaction($transactionId)  
	{
		return PagSeguroTransactionSearchService::searchByCode(  
	    															static::credentials(),  
	    															$transactionId
																);
	}

	public function getPaymentURL()
	{
		$request = new PagSeguroPaymentRequest;

		foreach($this->paymentData['items'] as $item) {
			$request->addItem($item['id'], $item['name'], $item['quantity'], $item['price']);
		}

		$request->setSender(
			$this->paymentData['buyerName'],
			$this->paymentData['buyerEmail'],
			$this->paymentData['buyerTelephoneArea'],
			$this->paymentData['buyerTelephone']
		);

		$request->setShippingAddress(
			$this->paymentData['buyerAddress']['zipCode'],
			$this->paymentData['buyerAddress']['street'],
			$this->paymentData['buyerAddress']['number'],
			$this->paymentData['buyerAddress']['additionalInfo'],
			$this->paymentData['buyerAddress']['neighborhood'],
			$this->paymentData['buyerAddress']['city'],
			$this->paymentData['buyerAddress']['state'],
			'BRA'
		);

		$request->setRedirectURL( URL::route('pagseguro.payment.redirect',$this->paymentData['orderId']) );

		$request->setCurrency("BRL");

		$request->setShippingType(3); // not specified

		$request->setReference($this->paymentData['orderId']);

		$request->setRedirectURL( URL::route('pagseguro.transaction.accepted.get', $this->paymentData['orderId']) );

		try 
		{
			if (App::environment() === 'development') 
			{
				$url = 'https://pagseguro.uol.com.br/checkout/sender-data.jhtml?senderPhone=25563164&senderAreaCode=21&senderName=Antonio%20Carlos%20Ribeiro&t=fc0d1591966a69898ee36e935da48fbd';
			}
			else
			{
				$url = $request->register( static::credentials() ); 
			}

			Log::info('PAGSEGURO - PAYMENT URL - '.$url);

			return $url;
		} 
		catch (PagSeguroServiceException $e) 
		{
			$errors = 'Erro ao efetuar transação no PagSeguro.';

			Log::error('PAGSEGURO - HTTP STATUS - ' . $e->getHttpStatus());

			foreach ($e->getErrors() as $key => $error) {  
				Log::error('PAGSEGURO - ERROR - ' . $error->getCode() . ' - ' . $error->getMessage());
			}

			return false;
		}
	}

	public static function convertDate($date)
	{
		return Carbon\Carbon::createFromFormat("Y-m-d\TH:i:s.uP", $date);
	}
}