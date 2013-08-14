<?php namespace Payment\Cielo;

use MrPrompt\Cielo\Transacao;
use MrPrompt\Cielo\Cliente;
use MrPrompt\Cielo\Autorizacao;
use MrPrompt\Cielo\Cartao;
use Carbon\Carbon;

use Payment\PaymentData;
use Payment\PaymentConfiguration;

class Cielo {

	private $paymentData;
	private $transaction;
	private $card;
	private $client;
	public $request;

	public function __construct(PaymentData $paymentData, PaymentConfiguration $configuration)
	{
		$this->paymentData = $paymentData;
		$this->configuration = $configuration;

		/// this should be going to service providers!

		$this->createCielo();
		$this->configure();
		$this->createCard();
		$this->createTransaction();
	}

	public function configure()
	{
		$this->client->setAmbiente($this->configuration->environment);
	}

	public function requestTransaction()
	{
		$this->request = $cielo->iniciaTransacao($this->transaction, $this->card, $this->configuration->returnUrl);
	}

	protected function createCielo()
	{
		$this->client = new Cliente(new Autorizacao($this->configuration->merchantId, $this->configuration->merchantKey));
	}

	public function createTransaction()
	{
		$this->transaction = new Transacao();

		$this->transaction->setTid( $this->paymentData->tid );
		$this->transaction->setAutorizar( false );
		$this->transaction->setCapturar( $this->paymentData->automaticCapture ? 'true' : 'false' );
		$this->transaction->setDataHora( Carbon::createFromTimestamp($this->paymentData->dateTime)->format('Y-m-d\Th:i:s') );
		$this->transaction->setDescricao( $this->paymentData->description );
		$this->transaction->setMoeda( 986 ); // Brazilian R$
		$this->transaction->setNumero( $this->paymentData->orderId );
		$this->transaction->setParcelas( $this->paymentData->installments );
		$this->transaction->setValor( $this->paymentData->value );
	}

	public function getTransactionId()
	{
		return isset($this->paymentData->transactionId) and !empty($this->paymentData->transactionId) 
				? $this->paymentData->transactionId 
				: $this->paymentData->orderId;
	}

	protected function createCard()
	{
		$this->card = new Cartao();
		$this->card->setBandeira( $this->paymentData->cardBrand );
		$this->card->setCartao( $this->paymentData->cardNumber );
		$this->card->setCodigoSeguranca( $this->paymentData->cardSecurityCode );
		$this->card->setIndicador( $this->paymentData->cardSecurityCodeInfo );
		$this->card->setNomePortador( $this->paymentData->cardPrintedName );
		$this->card->setValidade( $this->paymentData->cardExpirationDate );		
	}

}