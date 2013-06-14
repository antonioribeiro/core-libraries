<?php

class Payment {

	private $email = 'acr@antoniocarlosribeiro.com';
	private $token = '9E65DE53B8104211BB35420947531577';
	private $service;
	private $credentials;
	public $order;

	public $errors;

	public function __construct($order = null)
	{
		PagSeguroLibrary::init();

		$this->createCredentials();

		if(!empty($order))
		{
			$this->setOrder($order);
		}
	}

	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function getPaymentURL()
	{
		$this->service = new PagSeguroPaymentRequest;

		foreach($this->order['items'] as $item) {
			$this->service->addItem($item['id'], $item['name'], $item['quantity'], $item['price']);
		}

		$this->service->setSender(
			$this->order['buyerName'],
			$this->order['buyerEmail'],
			$this->order['buyerTelephoneArea'],
			$this->order['buyerTelephone']
		);

		$this->service->setShippingAddress(
			$this->order['buyerAddress']['zipCode'],
			$this->order['buyerAddress']['street'],
			$this->order['buyerAddress']['number'],
			$this->order['buyerAddress']['additionalInfo'],
			$this->order['buyerAddress']['neighborhood'],
			$this->order['buyerAddress']['city'],
			$this->order['buyerAddress']['state'],
			'BRA'
		); 

		$this->service->setRedirectURL( URL::route('pagseguro.payment.redirect',$this->order['orderId']) );

		$this->service->setCurrency("BRL");

		$this->service->setShippingType(3); // not specified

		$this->service->setReference($this->order['orderId']);

		$this->service->setRedirectURL( URL::route('pagseguro.transaction.accepted.get', $this->order['orderId']) );

		try {
			// $url = $this->service->register($this->credentials); 

			$url = 'https://pagseguro.uol.com.br/checkout/sender-data.jhtml?senderPhone=25563164&senderAreaCode=21&senderName=Antonio%20Carlos%20Ribeiro&t=fc0d1591966a69898ee36e935da48fbd';

			Log::info('PAGSEGURO - TRANSACTION - '.$url);

			return $url;
		} catch (PagSeguroServiceException $e) { // Caso ocorreu algum erro
			$this->errors = 'Erro ao efetuar transação no PagSeguro.';

			Log::error('PAGSEGURO - HTTP STATUS - ' . $e->getHttpStatus());

			foreach ($e->getErrors() as $key => $error) {  
				Log::error('PAGSEGURO - ERROR - ' . $error->getCode() . ' - ' . $error->getMessage());
			}

			return false;
		}
	}

	private function createCredentials()
	{
		$this->credentials = new PagSeguroAccountCredentials(  
			$this->email,   
			$this->token  
		);
	}

	public function getTransaction($transactionId)  
	{
		return $transaction = PagSeguroTransactionSearchService::searchByCode(  
	    																		$this->credentials,  
	    																		$transactionId
																			);  	
	}
	
}
