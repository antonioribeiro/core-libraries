<?php namespace Payment\Cielo;

use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cartao;
use Carbon\Carbon;

use Payment\PaymentData;
use Payment\PaymentConfiguration;

	//////////////// CHECK FOR ERRORS!!!!!!!
	// if( $cielo->hasErrors() )
	// {
	// 	echo 'erro: '.$cielo->getErrorCode().' - '.$cielo->getErrorMessage();
	// }
	// else
	// {
	// 	echo '<br>token: '.$cielo->getResponseData()->token->{'dados-token'}->{'codigo-token'};
	// 	echo '<br>cartao: '.$cielo->getResponseData()->token->{'dados-token'}->{'numero-cartao-truncado'};
	// 	echo '<br>status: '.$cielo->getResponseData()->token->{'dados-token'}->{'status'};
	// }

class Cielo {

	public $data;
	public $transaction;
	public $card;
	public $client;
	public $requestObject;
	public $request;
	public $response;
	public $responseCode;
	public $statusCode;
	public $configuration;

	public function __construct(PaymentData $data, PaymentConfiguration $configuration)
	{
		$this->data = $data;
		$this->configuration = $configuration;

		/// this should be going to service providers!
	}

	public function setUp()
	{
		$this->createCielo();
		$this->configure();
		$this->createTransaction();
		$this->createCard();
	}

	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}

		return $this;
	}

	public function configure()
	{
		$this->client->setAmbiente($this->configuration->environment);
	}

	protected function createCielo()
	{
		$this->client = new Cliente(new Autorizacao($this->configuration->merchantId, $this->configuration->merchantKey));
	}

	public function createTransaction()
	{
		$this->transaction = new Transacao();

		$this->transaction->setTid( $this->data->transactionId );
		$this->transaction->setAutorizar( $this->data->autorizationKind ); 
		$this->transaction->setCapturar( $this->data->automaticCapture ? 'true' : 'false' );
		$this->transaction->setDataHora( Carbon::createFromTimestamp($this->data->dateTime)->format('Y-m-d\Th:i:s') );
		$this->transaction->setDescricao( $this->data->description );
		$this->transaction->setMoeda( 986 ); // Brazilian R$
		$this->transaction->setNumero( $this->data->orderId );
		$this->transaction->setParcelas( $this->data->installments );
		$this->transaction->setValor( $this->data->value );
	}

	protected function createCard()
	{
		$this->card = new Cartao();

		if( ! is_null($this->data->cardBrand))
		{
			$this->card->setBandeira( $this->data->cardBrand );
		}

		if( ! is_null($this->data->cardNumber))
		{
			$this->card->setCartao( $this->data->cardNumber );
		}

		if ( ! is_null($this->data->cardSecurityCode)) 
		{
			$this->card->setCodigoSeguranca( $this->data->cardSecurityCode );
			$this->card->setIndicador( $this->data->cardSecurityCodeInfo );
		}

		if ( ! is_null($this->data->cardPrintedName)) 
		{
			$this->card->setNomePortador( $this->data->cardPrintedName );
		}

		if ( ! is_null($this->data->cardExpirationDate)) 
		{
			$this->card->setValidade( $this->convertExpirationDate( $this->data->cardExpirationDate ) );
		}

		if ( ! is_null($this->data->cardToken)) 
		{
			$this->card->setToken( $this->data->cardToken );
		}
	}

	public function hasErrors()
	{
		return $this->requestObject->getResposta()->getName() ===  'erro';
	}

	public function getErrorCode()
	{
		if ($this->hasErrors()) 
		{
			return $this->requestObject->getResposta()->codigo;
		}

		return false;
	}

	public function getErrorMessage()
	{
		if ($this->hasErrors()) 
		{
			return (string) $this->requestObject->getResposta()->mensagem;
		}

		return '';
	}

	public function requestTransaction()
	{
		$this->setUp();
		$this->setRequest( $this->client->iniciaTransacao($this->transaction, $this->card, $this->configuration->returnUrl) );

		return ! $this->hasErrors();
	}

	public function requestToken()
	{
		$this->setUp();
		$this->setRequest( $this->client->solicitaToken($this->transaction, $this->card) );

		return ! $this->hasErrors();
	}

	public function requestStatusQuery()
	{
		$this->setUp();
		$this->setRequest( $this->client->consulta($this->transaction, $this->card) );

		return ! $this->hasErrors();
	}

	public function requestCapture()
	{
		$this->setUp();
		$this->setRequest( $this->client->captura($this->transaction) );

		return ! $this->hasErrors();
	}

	public function setRequest($request)
	{
		$this->requestObject = $request;

		$this->request = $this->requestObject->getEnvio();
		$this->response = $this->requestObject->getResposta();

		if(! $this->hasErrors())
		{
			$this->processResponseData();
		}
	}

	private function processResponseData()
	{
		$this->responseCode = new ResponseCode( $this->response->autorizacao->lr );
		$this->statusCode =  new StatusCode( $this->response->status );

		if( empty($this->data->transactionId) )
		{
			$this->data->transactionId = $this->response->tid;
		}
	}

	private function convertExpirationDate( $date )
	{
		$parts = explode('/', $date);

		if (count($parts) > 1)
		{
			$date = $parts[1].$parts[0];
		}

		return $date;
	}

}