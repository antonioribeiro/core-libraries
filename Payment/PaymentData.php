<?php namespace Payment;

class PaymentData {

	public $transactionId;
	public $autorize = false;
	public $automaticCapture = false;
	public $dateTime;
	public $description;
	public $currency = 986; // Brazilian R$
	public $orderId;
	public $installments = 1; /// 1 parcela
	public $value;
	public $cardBrand;
	public $cardNumber;
	public $cardPrintedName;
	public $cardExpirationDate;
	public $cardSecurityCodeInfo; /// 0 = Not Informed --- 1 = Will Send Security Code --- 2 = Illegible
	public $cardSecurityCode;

	public function getTid()
	{
		return isset($this->transactionId) and !empty($this->transactionId) 
				? $this->transactionId 
				: $this->orderId;
	}

	public function setTid($id)
	{
		$this->transactionId = $id;
	}
}