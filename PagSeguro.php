<?php

require_once __DIR__."/../../vendor/pagseguro/source/PagSeguroLibrary/PagSeguroLibrary.php";

class PagSeguro {
	
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

	public static function getPaymentURL($order)
	{
		$request = new PagSeguroPaymentRequest;

		foreach($order['items'] as $item) {
			$request->addItem($item['id'], $item['name'], $item['quantity'], $item['price']);
		}

		$request->setSender(
			$order['buyerName'],
			$order['buyerEmail'],
			$order['buyerTelephoneArea'],
			$order['buyerTelephone']
		);

		$request->setShippingAddress(
			$order['buyerAddress']['zipCode'],
			$order['buyerAddress']['street'],
			$order['buyerAddress']['number'],
			$order['buyerAddress']['additionalInfo'],
			$order['buyerAddress']['neighborhood'],
			$order['buyerAddress']['city'],
			$order['buyerAddress']['state'],
			'BRA'
		); 

		$request->setRedirectURL( URL::route('pagseguro.payment.redirect',$order['orderId']) );

		$request->setCurrency("BRL");

		$request->setShippingType(3); // not specified

		$request->setReference($order['orderId']);

		$request->setRedirectURL( URL::route('pagseguro.transaction.accepted.get', $order['orderId']) );

		try 
		{
			$url = $request->register(static::credentials()); 

			// $url = 'https://pagseguro.uol.com.br/checkout/sender-data.jhtml?senderPhone=25563164&senderAreaCode=21&senderName=Antonio%20Carlos%20Ribeiro&t=fc0d1591966a69898ee36e935da48fbd';

			Log::info('PAGSEGURO - TRANSACTION - '.$url);

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