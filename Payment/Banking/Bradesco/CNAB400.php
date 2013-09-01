<?php

class CNAB400 {
	static function generateFile($records) {
		return 
			CNAB400::generateHeader($records).
			CNAB400::generateTransaction($records).
			CNAB400::generateMessage($records).
			CNAB400::generateCreditApportionment($records).
			CNAB400::generateDrawer($records).
			CNAB400::generateTrailler($records).
			'';
	}

	static function generateHeader($records) {
		return 
			'0'. 											// 001 a 001 Identificação do Registro
			'1'. 											// 002 a 002 Identificação do Arquivo Remessa 
			'REMESSA'. 										// 003 a 009 Literal Remessa
			'01'. 											// 010 a 011 Código de Serviço 002 01 
			str_pad('COBRANCA', 15, " ", STR_PAD_RIGHT). 	// 012 a 026 Literal Serviço 015 COBRANCA  
			'00000000000004560485'. 						// 027 a 046 Código da Empresa
			'CyS Cypher Systems Consultoria'. 				// 047 a 076 Nome da Empresa char(30)
			'237'. 											// 077 a 079 Número do Bradesco na Câmara de Compensação 
			str_pad('Bradesco', 15, " ", STR_PAD_RIGHT). 	// 080 a 094 Nome do Banco por Extenso
			date("dmy"). 									// 095 a 100 Data da Gravação do Arquivo DDMMAA
			str_repeat(' ', 8). 							// 101 a 108 Branco
			'MX'. 											// 109 a 110 Identificação do sistema 
			str_pad('1', 7, "0", STR_PAD_LEFT). 			// 111 a 117 Nº Seqüencial de Remessa
			str_repeat(' ', 277). 							// 118 a 394 Branco
			str_pad('1', 6, "0", STR_PAD_LEFT). 			// 395 a 400 Nº Seqüencial do Registro de Um em Um
			'';
	}

	static function generateTransaction($records) {
		return 
			'1'. 											// 001 a 001 Identificação do Registro
			str_repeat(' ', 5). 							// 002 a 006 Agência de Débito (opcional) 
			' '. 										// 007 a 007 Dígito da Agência de Débito (opcional)
			str_repeat(' ', 5). 											//  008 a 012 Razão da Conta Corrente (opcional)
			str_repeat(' ', 7). 											//  013 a 019 Conta Corrente (opcional)
 			' '. 										// 020 a 020 Dígito da Conta Corrente (opcional)
 			'00000934690410004'. 										// 021 a 037 Identificação da Empresa Cedente no Banco 
 			str_repeat(' ', 25). 										// 038 a 062 Nº Controle do Participante 
 			'237'. 										// 063 a 065 Código do Banco a ser debitado na Câmara de Compensação 
 			'2'. 										// 066 a 066 Campo de Multa
 			'0200'. 										// 067 a 070 Percentual de multa
 			'nossonumero'. 										// 071 a 081 Identificação do Título no Banco (nosso numero)
 			' '. 										// 082 a 082 Digito de Auto Conferencia do Número Bancário.
 			' '. 										// 021 a 037 Identificação da Empresa Cedente no Banco 
 			' '. 										// 021 a 037 Identificação da Empresa Cedente no Banco 
 			' '. 										// 021 a 037 Identificação da Empresa Cedente no Banco 
 

			str_pad('COBRANCA', 15, " ", STR_PAD_RIGHT). 	// 012 a 026 Literal Serviço 015 COBRANCA  
			'00000000000004560485'. 						// 027 a 046 Código da Empresa
			'CyS Cypher Systems Consultoria'. 				// 047 a 076 Nome da Empresa char(30)
			'237'. 											// 077 a 079 Número do Bradesco na Câmara de Compensação 
			str_pad('Bradesco', 15, " ", STR_PAD_RIGHT). 	// 080 a 094 Nome do Banco por Extenso
			date("dmy"). 									// 095 a 100 Data da Gravação do Arquivo DDMMAA
			str_repeat(' ', 8). 							// 101 a 108 Branco
			'MX'. 											// 109 a 110 Identificação do sistema 
			str_pad('1', 7, "0", STR_PAD_LEFT). 			// 111 a 117 Nº Seqüencial de Remessa
			str_repeat(' ', 277). 							// 118 a 394 Branco
			str_pad('1', 6, "0", STR_PAD_LEFT). 			// 395 a 400 Nº Seqüencial do Registro de Um em Um
			'';
	}

	static function generateMessage($records) {}

	static function generateCreditApportionment($records) {}

	static function generateDrawer($records) {}

	static function generateTrailler($records) {}
}

