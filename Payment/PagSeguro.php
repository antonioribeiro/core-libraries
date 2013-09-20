<?php

require_once __DIR__."/../../../../../vendor/pagseguro/source/PagSeguroLibrary/PagSeguroLibrary.php";

class PagSeguro implements PaymentGatewayInterface {

	private $request;
	private $paymentData;

	public $errors = [];
	public $log = [];
	public $paymentURL;
	public $redirectURL = null; /// URL::route('pagseguro.payment.redirect',$this->paymentData['orderId'])
	public $email;
	public $token; // Config::get('app.pagseguro.email'), Config::get('app.pagseguro.token')  

	public function __construct(array $paymentData, PagSeguroPaymentRequest $request)
	{
		$this->paymentData = $paymentData;
		$this->request = $request;
	}
	
	public function pay()
	{
		$this->clearErrors();

		if ( ! $this->checkAllData() )
		{
			return false;
		}

		return $this->buildPaymentURL();
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

	public function setPaymentData($data)
	{
		$this->paymentData = $data;
	}

	public function credentials()
	{
		if ( empty($this->email) or empty($this->token) )
		{
			$this->throwException('credentials cannot be blank.');
		}

		return new PagSeguroAccountCredentials(  
												$this->email,   
												$this->token  
											);		
	}

	private function clearErrors()
	{
		$this->errors = [];
	}

	private function checkCredentials()
	{
		if ( empty($this->email) or empty($this->token) )
		{
			$this->errors[] = 'credentials are not set.';

			return false;
		}

		return true;
	}

	public function getNotification($notificationCode)  
	{
		return PagSeguroNotificationService::checkTransaction($this->credentials(), $notificationCode);
	}

	public function getTransaction($transactionId)  
	{
		return PagSeguroTransactionSearchService::searchByCode(  
	    															$this->credentials(),  
	    															$transactionId
																);
	}

	private function checkRedirectURL()
	{
		if ( empty($this->redirectURL) )
		{
			$this->errors[] = 'redirectURL property cannot be empty.';

			return false;
		}

		return true;
	}

	public function convertDate($date)
	{
		return Carbon\Carbon::createFromFormat("Y-m-d\TH:i:s.uP", $date);
	}

	private function verifyAndSetPaymentData()
	{
		if ( ! isset($this->paymentData['items']) )
		{
			$this->errors[] = 'invalid payment data.';
			return false;
		}

		if ( ! isset($this->paymentData['orderId']) )
		{
			$this->errors[] = 'invalid payment data.';
			return false;
		}

		if ( ! array_key_exists('items', $this->paymentData) or ! array_key_exists('orderId', $this->paymentData) )
		{
			$this->errors[] = 'invalid payment data.';
			return false;
		}

		foreach($this->paymentData['items'] as $item) {
			$this->request->addItem($item['id'], $item['name'], $item['quantity'], $item['price']);
		}

		$this->request->setSender(
			$this->paymentData['buyerName'],
			$this->paymentData['buyerEmail'],
			$this->paymentData['buyerTelephoneArea'],
			$this->paymentData['buyerTelephone']
		);

		$this->request->setShippingAddress(
			$this->paymentData['buyerAddress']['zipCode'],
			$this->paymentData['buyerAddress']['street'],
			$this->paymentData['buyerAddress']['number'],
			$this->paymentData['buyerAddress']['additionalInfo'],
			$this->paymentData['buyerAddress']['neighborhood'],
			$this->paymentData['buyerAddress']['city'],
			$this->paymentData['buyerAddress']['state'],
			'BRA'
		);

		$this->request->setCurrency("BRL");

		$this->request->setShippingType(3); // not specified

		$this->request->setReference($this->paymentData['orderId']);

		$this->request->setRedirectURL( $this->redirectURL );

		return true;	
	}

	private function checkAllData()
	{
		if ( ! $this->checkCredentials() ) {
			return false;
		}

		if ( ! $this->checkRedirectURL() ) {
			return false;
		}

		if ( ! $this->verifyAndSetPaymentData() ) {
			return false;
		}

		return true;
	}

	public function buildPaymentURL()
	{
		try 
		{
			if (App::environment() === 'development') 
			{
				$url = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=C4BD7A9990902D6EE4821FB7DCFF47E6';
			}
			else
			{
				$url = $this->request->register( $this->credentials() ); 
			}

			$this->log['info'][] = 'PAGSEGURO - PAYMENT URL - '.$url;

			$this->paymentURL = $url;
		} 
		catch (PagSeguroServiceException $e) 
		{
			$this->errors[] = 'Erro ao efetuar transação no PagSeguro.';

			$this->log['error'][] = 'PAGSEGURO - HTTP STATUS - ' . $e->getHttpStatus();

			foreach ($e->getErrors() as $key => $error) {  
				Log::error('PAGSEGURO - ERROR - ' . $error->getCode() . ' - ' . $error->getMessage());
			}

			$this->paymentURL = 'error';

			return false;
		}

		return true;
	}

}