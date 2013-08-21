<?php

interface PaymentGatewayInterface {

	public function pay();
	public function processNotification($notification);
	public function getPaymentStyle();
	public function getPaymentData();

}