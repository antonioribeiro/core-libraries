<?php

class Payment {

	public $service;

	public function __construct($paymentData)
	{

		$this->service = new PagSeguro($paymentData);
		
	}

}

// redirectURL = https://staging.vevey.com.br/pagseguro/transaction/accepted/701038

// [2013-06-14 06:51:28] log.INFO: PAGSEGURO - TRANSACTION - https://pagseguro.uol.com.br/v2/checkout/payment.html?code=FECB5FE03F3FE17444E1AFA256DD2F6A [] []
// [2013-06-14 07:00:53] log.INFO: PAGSEGURO - NOTIFICATION - 186.234.16.9 - {"notificationCode":"5C1D4C-16A801A80173-6994F5BFB626-6E6745","notificationType":"transaction","\/pagseguro\/notification":""} [] []
// [2013-06-14 07:01:00] log.INFO: PAGSEGURO - TRANSACTION - order id: 701038 - 186.205.66.95 - {"\/pagseguro\/transaction\/accepted\/701038":""} [] []
// [2013-06-14 09:15:18] log.INFO: PAGSEGURO - NOTIFICATION - 186.234.16.8 - {"notificationCode":"5C1D4C-16A801A80173-6994F5BFB626-6E6745","notificationType":"transaction","\/pagseguro\/notification":""} [] []
// [2013-06-14 11:15:23] log.INFO: PAGSEGURO - NOTIFICATION - 186.234.16.9 - {"notificationCode":"5C1D4C-16A801A80173-6994F5BFB626-6E6745","notificationType":"transaction","\/pagseguro\/notification":""} [] []
// [2013-06-14 13:17:22] log.INFO: PAGSEGURO - NOTIFICATION - 186.234.16.8 - {"notificationCode":"5C1D4C-16A801A80173-6994F5BFB626-6E6745","notificationType":"transaction","\/pagseguro\/notification":""} [] []
// [2013-06-14 15:18:13] log.INFO: PAGSEGURO - NOTIFICATION - 186.234.16.8 - {"notificationCode":"5C1D4C-16A801A80173-6994F5BFB626-6E6745","notificationType":"transaction","\/pagseguro\/notification":""} [] []

