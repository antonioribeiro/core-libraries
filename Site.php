<?

class Site {

	static public function buildTopMenu() {

		$menu[] = ['caption' => '(21) 2556-3164&nbsp;&nbsp;<i class="icon icon-double-angle-left"></i><i class="icon icon-double-angle-right"></i>&nbsp;&nbsp;Contato', 'url' => URL::route('home'), 'icon' => 'icon-phone'];

		$menu[] = ['caption' => 'Carrinho', 'url' => URL::route('home'), 'icon' => 'icon-shopping-cart'];

		if(false) 
		{
			$menu[] = ['caption' => 'Finalizar Compra', 'url' => URL::route('home')];
		}

		if(Sentry::check()) 
		{
			$menu[] = ['caption' => 'Sua lista de desejos', 'url' => URL::route('users.profile'), 'icon' => 'icon-heart'];
			$menu[] = ['caption' => 'Sua Conta', 'url' => URL::route('users.profile'), 'icon' => 'icon-user'];
		} 
		else 
		{
			$menu[] = ['caption' => 'Sua Conta', 'url' => URL::route('login'), 'icon' => 'icon-user'];
			$menu[] = ['caption' => 'Cadastre-se', 'url' => URL::route('login'), 'icon' => 'icon-book'];
		}

		if(Sentry::check()) 
		{
			$menu[] = ['caption' => 'Sair', 'url' => URL::route('logout'), 'icon' => 'icon-signout'];
		} 

		return $menu;
	}

	static public function buildMainMenu() {

		$menu[] = [	'caption' => 'Feminino', 
					'url' => URL::route('home'), 
					'items' => [
									['caption' => 'Blusas', 'url' => URL::route('home')],
									['caption' => 'Saias', 'url' => URL::route('home')],
									['caption' => 'Acessórios', 'url' => URL::route('home')],
								],
					];

		$menu[] = [	'caption' => 'Masculino', 
					'url' => URL::route('home'), 
					'items' => [
									['caption' => 'Camisas', 'url' => URL::route('home')],
									['caption' => 'Sapatos', 'url' => URL::route('home')],
									['caption' => 'Ternos', 'url' => URL::route('home')],
								],
					];

		return $menu;
	}

}



