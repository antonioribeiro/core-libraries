<?

class Site {

	static public $menuRoute = 'store.categories';

	static public function buildTopMenu() {

		$route = 'home';

		//$menu[] = ['caption' => '(21) 2556-3164&nbsp;&nbsp;<i class="icon icon-double-angle-left"></i><i class="icon icon-double-angle-right"></i>&nbsp;&nbsp;Contato', 'url' => URL::route($route), 'icon' => 'icon-phone'];

		$menu[] = ['caption' => 'Carrinho'.(Cart::quantity() > 0 ? ' ('.(integer) Cart::quantity().')' : ''), 'url' => URL::route('store.cart'), 'icon' => 'icon-shopping-cart'];

		if (false) 
		{
			$menu[] = ['caption' => 'Finalizar Compra', 'url' => URL::route($route)];
		}

		if (Sentry::check()) 
		{
			$menu[] = ['caption' => 'Sua lista de desejos', 'url' => URL::route('profile.show', ActiveSession::user()->id), 'icon' => 'icon-heart'];
			$menu[] = ['caption' => ActiveSession::user()->email, 'url' => URL::route('profile.show', ActiveSession::user()->id), 'icon' => 'icon-user'];
		} 
		else 
		{
			$menu[] = ['caption' => 'Login', 'url' => URL::route('login'), 'icon' => 'icon-user'];
			$menu[] = ['caption' => 'Cadastre-se', 'url' => URL::route('register'), 'icon' => 'icon-book'];
		}

		if (Sentry::check()) 
		{
			$menu[] = ['caption' => 'Sair', 'url' => URL::route('logout'), 'icon' => 'icon-signout'];
		} 

		return $menu;
	}

	static public function buildMainMenu() {

		$category = Category::find(1); // get the first levels

		$menu = static::menuItems($category);

		// ['caption' => 'Blusas', 'url' => URL::route($route)],
		// ['caption' => 'Saias', 'url' => URL::route($route)],
		// ['caption' => 'Acessórios', 'url' => URL::route($route)],

		if (Group::has('system.admin'))
		{
			$menu[] = [	'caption' => 'Administração', 
						'url' => URL::route('admin.index'),
						'items' => [],
						];

			$menu[] = [	'caption' => 'Derrubar Sessão', 
						'url' => URL::route('admin.session.flush'),
						'items' => [],
						];
		}

		return $menu;
	}

	static public function menuItems($parent)
	{
		$categories = Category::where('parent_id', $parent->id)->where('active',true)->where('id','<>',$parent->id)->get();

		$menu = [];

		foreach($categories as $category)
		{
			$menu[] = 	[	
							'caption' => $category->name, 
							'url' => URL::route(static::$menuRoute, $category->id), 
							'items' => static::menuItems($category),
						];
		}

		return $menu;
	}	

}
