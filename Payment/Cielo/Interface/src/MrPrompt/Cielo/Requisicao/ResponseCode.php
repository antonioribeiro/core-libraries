<?php namespace Payment\Cielo;

class ResponseCode {
	public $responseCode;
	public $message;
	public $description;
	public $allowRetry;
	public $success;

	protected $codes = [
							'00' => [
										'message' => 'Transação autorizada', 
										'description' => '<ul><li>Fechar pedigo como "Pago"</li></ul>', 
										'allowRetry' => false
									],

							'01' => [
										'message' => 'Transação referida pelo emissor', 
										'description' => '<ul><li>Oriente o portador a contatar o emissor do cartão</li></ul>', 
										'allowRetry' => false
									],

							'03' => [
										'message' => 'Não foi encontrada transação para o Tid', 
										'description' => '<ul><li>Número de parcelas ultrapassa o permitido.</li><li>Código de segurança inválido</li><li>Número do cartão inválido</li><li>Instabilidade no sistema da Cielo</li></ul>', 
										'allowRetry' => false
									],

							'04' => [
										'message' => 'Cartão com restrição', 
										'description' => '<ul><li>Oriente o portador a contatar o emissor do cartão</li></ul>', 
										'allowRetry' => false
									],

							'05' => [
										'message' => 'Transação não autorizada', 
										'description' => '<ul><li>Contate o emissor do seu cartão, pois o banco emissor do cartão não autorizou a venda.</li></ul>', 
										'allowRetry' => false
									],

							'06' => [
										'message' => 'Tente novamente', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => true
									],

							'07' => [
										'message' => 'Cartão com restrição', 
										'description' => '<ul><li>Oriente o portador do cartão a contatar o emissor do cartão</li></ul>', 
										'allowRetry' => false
									],

							'08' => [
										'message' => 'Código de segurança inválido', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'10' => [
										'message' => 'Não é permitido o envio do cartão', 
										'description' => '<ul><li>O estabelecimento não possui liberação para enviar o cartão, a chave foi gerada na Cielo para a modalidade Buy Page Cielo e o meio de pagamento em que se está realizando o teste é Buy Page Loja. Caso a homologação tenha sido solicitada para Buy Page Loja é necessário entrar em contato com a Operadora para que eles realizem um ajuste na configuração.</li></ul>', 
										'allowRetry' => false
									],

							'11' => [
										'message' => 'Venda com Parcelado tipo "2" não habilitado', 
										'description' => '<ul><li>Verificar com o operadora qual limite de parcelamento do estabelecimento no Parcelado Loja</li></ul>', 
										'allowRetry' => false
									],

							'12' => [
										'message' => 'Transação inválida', 
										'description' => '<ul><li>Venda não autorizada pelo banco emissor do cartão.Erro no cartão</li></ul>', 
										'allowRetry' => false
									],

							'13' => [
										'message' => 'Valor inválido', 
										'description' => '<ul><li>Verificar o valor do pedido e a forma de pagamento, pois para compras parceladas o valor mínimo do pedido deverá ser R$ 10,00(R$ 5,00 por parcela).</li></ul>', 
										'allowRetry' => false
									],

							'14' => [
										'message' => 'Cartão inválido', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'15' => [
										'message' => 'Emissor inválido', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'41' => [
										'message' => 'Cartão com restrição', 
										'description' => '<ul><li>Cliente deve entrar em contato com o banco emissor do cartão para verificar por que o banco não está autorizando a compra</li></ul>', 
										'allowRetry' => false
									],

							'51' => [
										'message' => 'Saldo insuficiente', 
										'description' => '<ul><li>Cliente deve entrar em contato com o banco para verificar por que o banco não está autorizando a compra</li></ul>', 
										'allowRetry' => true
									],

							'54' => [
										'message' => 'Cartão vencido ou data de vencimento incorreta', 
										'description' => '<ul><li>Caso os dados informados estejam corretos, cliente deve entrar em contato com o banco para verificar se cartão ainda é valido</li></ul>', 
										'allowRetry' => false
									],

							'57' => [
										'message' => 'Transação não permitida ou não autorizada', 
										'description' => '<ul><li>Venda não autorizada pelo emissor do cartão, pois o cartão utilizado não faz parte da rede  Verified by Visa ou o sistema de prevenção do banco não autorizou a compra, neste caso o cliente deverá realizar contato com banco emissor do  cartão e informar que está tentando realizar uma compra no valor R$XXX e não está sendo autorizada.</li></ul>', 
										'allowRetry' => false
									],

							'58' => [
										'message' => 'Transação não permitida', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'62' => [
										'message' => 'Cartão com restrição', 
										'description' => '<ul><li>Oriente o portador a contatar o emissor do cartão</li></ul>', 
										'allowRetry' => false
									],

							'63' => [
										'message' => 'Cartão com restrição', 
										'description' => '<ul><li>Oriente o portador a contatar o emissor do cartão</li></ul>', 
										'allowRetry' => false
									],

							'76' => [
										'message' => 'Tente novamente', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => true
									],

							'78' => [
										'message' => 'Cartão não foi desbloqueado pelo portador', 
										'description' => '<ul><li>Cartão bloqueado. O portador do cartão não desbloqueou o cartão para poder utilizá-lo. Oriente o portador a desbloquea-lo junto ao emissor do cartão.</li></ul>', 
										'allowRetry' => true
									],

							'81' => [
										'message' => 'Transação negada', 
										'description' => '<ul><li>Banco emissor do cartão inválido</li></ul>', 
										'allowRetry' => false
									],

							'82' => [
										'message' => 'Transação inválida', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'91' => [
										'message' => 'Banco indisponível', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => true
									],

							'96' => [
										'message' => 'Tente novamente', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => true
									],

							'99' => [
										'message' => 'Sistema do banco temporariamente fora de operação.', 
										'description' => '<ul><li>Tente novamente mais tarde.Também verificar:</li><li>1. Se o estabelecimento tem liberado na operadora o meio de pagamento Visa Electron</li><li>Para verificar se o estabelecimento tem liberado o meio de pagamento Visa Electron, realize contato com a Cielo, suporte Web.</li><li></li><li>2. Se o meio de pagamento Visa Electron estiver liberado, neste mesmo contato verifique se o estabelecimento tem habilitado(na operadora) o parcelamento realizado no pedido, pois possivelmente o parcelamento escolhido não está ativo para o Estabelecimento.</li></ul>', 
										'allowRetry' => true
									],

							'110' => [
										'message' => 'Não foi possível processar a transação. Sistema sem comunicação.', 
										'description' => '<ul><li>Banco emissor do cartão inválido.</li></ul>', 
										'allowRetry' => false
									],

							'196' => [
										'message' => 'Venda não autorizada', 
										'description' => '<ul><li>1 - Realizada Sonda e o retorno da operadora é: ars=transação finalizada antes de iniciar autorização.</li><li>Alguma informação do cartão não foi informada corretamente no momento da compra.</li><li>Cartão utilizado para realizar compra é cartão de testes da Cielo (cliente conseguiu o cartão de alguma forma e tentou realizar compra)</li></ul>'
									],

							'213' => [
										'message' => 'Não foi possível processar a transação.', 
										'description' => '<ul><li>Falha de comunicação com o banco emissor do cartão.</li><li>Verificar com a operadora o que ocorreu.</li></ul>'
									],

							'213' => [
										'message' => 'Não foi possível processar a transação.', 
										'description' => '<ul><li>Identificador da Transação TID duplicado.</li><li>Por alguma razão o pop-up da operadora abriu em segundo plano.</li><li>Ou  o pop-up não abriu porque tem bloqueador de pop-up no navegador e sem perceber o cliente clica em "Clique Aqui" no iPAGARE para forçar a abertura do pop-up, o mesmo TID (identificação única junto a VISA enviado na primeira tentativa) é reenviado, resultando na mensagem em questão (TID duplicado).</li></ul>'
									],

							'215' => [
										'message' => 'Transação não finalizada.', 
										'description' => '<ul><li>Possíveis dificuldades com pop-up bloqueado no navegador do cliente.</li></ul>'
									],

							'244' => [
										'message' => 'Não foi possível processar a transação.', 
										'description' => '<ul><li>Cartão utilizado pelo cliente não faz parte da rede autenticada Cielo.</li></ul>'
									],

							'995' => [
										'message' => 'Não foi possível processar a transação', 
										'description' => '<ul><li>Este erro ocorre pois autenticação não é finalizada  no ambiente da operadora.</li><li>Cartão  é internacional e o banco emissor do cartão não participa da rede Verified by Visa.</li><li>No caso do VBV a autenticação é realizada no ambiente da operadora e dependendo do banco emissor do cartão é necessário passar dados do cartão ou do cliente para finalizar pedido.</li><li>Cliente está tentando realizar a compra parcelada com cartão internacional,  para cartões internacionais não é possível comprar parcelado somente a vista.  Este erro ocorre tanto para a tecnologia MOSET e Verified By Visa.</li><li>Cliente estava utilizando cartão de débito como crédito.</li></ul>'
									],

							'997' => [
										'message' => 'Não foi possível processar a transação', 
										'description' => '<ul><li>Esse erro geralmente ocorre por falha na autenticação com banco, por este motivo podem aparecer mais de uma tentativa sem sucesso e outra finalizada.</li><li>Também ocorre quando o cliente digita os dados do cartão errado.</li></ul>'
									],

							'999' => [
										'message' => 'Não foi possível processar a transação', 
										'description' => '<ul><li>Pagamento não autorizado pelo banco emissor do cartão.</li><li>Este erro pode ocorrer nos casos em que o site da Cielo esteja tendo algum tipo de problema técnico interno.</li><li>Este erro também pode ocorrer quando a página onde são digitados os dados do cartão fica muito tempo aberta, aguardando a digitação dos dados.</li></ul>'
									],

							'5115' => [
										'message' => 'Não foi possível processar a transação', 
										'description' => '<ul><li>Tentativa de pagamento com cartão emitido no exterior que não autenticou com sucesso no Internet Banking do banco emissor</li></ul>'
									],

							'AA' => [
										'message' => 'Tente novamente', 
										'description' => '<ul><li>Devido a erros de comunicação muitas vezes a operadora simplesmente solicita que seja feita uma nova tentativa.</li></ul>', 
										'allowRetry' => true
									],

							'AC' => [
										'message' => 'Cartão de débito tentando utilizar produto crédito', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'GA' => [
										'message' => 'Transação referida pela Cielo', 
										'description' => '<ul><li>Aguarde contato da Cielo</li></ul>', 
										'allowRetry' => false
									],

							'N7' => [
										'message' => 'Código de segurança inválido (Visa)', 
										'description' => '<ul><li></li></ul>', 
										'allowRetry' => false
									],

							'ZZZ' => [
										'message' => 'Código LR inválido', 
										'description' => '<ul><li>Ocorreu um erro ao fazer uma consulta na Cielo.</li></ul>',
										'allowRetry' => false
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

		$this->responseCode = $this->codes[$this->code];
		$this->message = $this->codes[$this->code]['message'];
		$this->description = $this->codes[$this->code]['description'];
		$this->allowRetry = ! isset($this->codes[$this->code]['allowRetry']) ? false : $this->codes[$this->code]['allowRetry'];
		$this->success = $this->code === '00';			
	}
}
