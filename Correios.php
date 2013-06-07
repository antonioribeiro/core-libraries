<?

	// nCdServico = Código Serviço
	// 40010 SEDEX Varejo
	// 40045 SEDEX a Cobrar Varejo
	// 40215 SEDEX 10 Varejo
	// 40290 SEDEX Hoje Varejo
	// 41106 PAC Varejo

	// nIndicaCalculo=3
	// 1 - Só preço
	// 2 - Só prazo
	// 3 - Preço e Prazo

	// http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?

	// sCepOrigem= 70002900
	// sCepDestino=22220080
	// nVlPeso=0.300
	// nCdFormato=1
	// nVlComprimento=30
	// nVlAltura=30
	// nVlLargura=30
	// sCdMaoPropria=n
	// nVlValorDeclarado=1530530.00
	// sCdAvisoRecebimento=n
	// nCdServico=41106
	// nVlDiametro=0
	// StrRetorno=xml
	// nIndicaCalculo=3

	// http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?sCepOrigem=70002900&sCepDestino=22220080&nVlPeso=0.300&nCdFormato=1&nVlComprimento=30&nVlAltura=30&nVlLargura=30&sCdMaoPropria=n&nVlValorDeclarado=1530&sCdAvisoRecebimento=n&nCdServico=41106&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3

class Correios {

	public $cepOrigem = "22220-080";
	public $cepDestino;
	public $peso = 0.300;
	public $formato = 1;
	public $comprimento;
	public $altura;
	public $largura;
	public $maoPropria = "n";
	public $valorDeclarado = 0;
	public $avisoRecebimento = 0;
	public $codigoServico = "41106";
	public $diametro = 0;
	public $tipoRetorno = "xml";
	public $indicaCalculo = 3;

	public $url;

	public function makeURL()
	{
		$vars['sCepOrigem'] =          $this->cepOrigem;
		$vars['sCepDestino'] =         $this->cepDestino;
		$vars['nVlPeso'] =             $this->peso;
		$vars['nCdFormato'] =          $this->formato;
		$vars['nVlComprimento'] =      $this->comprimento;
		$vars['nVlAltura'] =           $this->altura;
		$vars['nVlLargura'] =          $this->largura;
		$vars['sCdMaoPropria'] =       $this->maoPropria;
		$vars['nVlValorDeclarado'] =   $this->valorDeclarado;
		$vars['sCdAvisoRecebimento'] = $this->avisoRecebimento;
		$vars['nCdServico'] =          $this->codigoServico;
		$vars['nVlDiametro'] =         $this->diametro;
		$vars['StrRetorno'] =          $this->tipoRetorno;
		$vars['nIndicaCalculo'] =      $this->indicaCalculo;

		$this->url = '';

		foreach($vars as $key => $value)
		{
			$this->url .= ($this->url ? "&" : '') . $key."=".$value;
		}

		$this->url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?' . $this->url;

		return $this->url;
	}

	public function calcula()
	{
		return Tools::XML2Array( file_get_contents( $this->makeURL() ) );
	}
}
