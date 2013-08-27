<?php namespace Payment\Cielo;

class StatusCode {
	public $statusCode;
	public $message;
	public $success;

	protected $codes = [
							'0' => [
										'message' => 'Transação Criada', 
										'success' => true
									],

							'1' => [
										'message' => 'Transação em Andamento', 
										'success' => true
									],

							'2' => [
										'message' => 'Transação Autenticada', 
										'success' => true
									],

							'3' => [
										'message' => 'Transação não Autenticada', 
										'success' => false
									],

							'4' => [
										'message' => 'Transação Autorizada', 
										'success' => true
									],

							'5' => [
										'message' => 'Transação não Autorizada', 
										'success' => false
									],

							'6' => [
										'message' => 'Transação Capturada', 
										'success' => true
									],

							'9' => [
										'message' => 'Transação Cancelada', 
										'success' => false
									],

							'10' => [
										'message' => 'Transação em Autenticação', 
										'success' => true
									],

							'12' => [
										'message' => 'Transação em Cancelamento', 
										'success' => true
									],

							'ZZZ' => [
										'message' => 'Ocorreu um erro ao consultar a Cielo', 
										'success' => false
									],
						];

	public function __construct($code)
	{
		$this->code = (string) $code;

		$this->selectMessage();
	}

	private function selectMessage()
	{
		if( ! isset($this->codes[$this->code]) )
		{
			$this->code = 'ZZZ';	
		}

		$this->statusCode = $this->codes[$this->code];
		$this->message = $this->codes[$this->code]['message'];
		$this->success = $this->codes[$this->code]['success'];
	}
}
