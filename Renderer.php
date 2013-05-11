<?php

class Renderer {

	public static function table($additionalTags, $rowsLinks, $model, $columns, $filter, $widgets) {

		/// columns format:
		//		<type>:<caption>:<size>:<column>:<css classes>,<type>:<caption>:<size>:<column>:<css classes>|<type>:<caption>:<size>:<column>:<css classes>
		//
		//	example:
		//		column:Nome:17%:name,column:E-mail:17%:email,method:Endereço:*:addressFull(),column:Telefones:17%:telephones,icons:Ações:17%|Editar:icon-pencil:#|Imprimir ficha:icon-print:#|Deletar:icon-trash:#
		//		
		$captions = array();
		foreach(explode(',',$columns) as $column) {
			$s = explode(':',$column);
			$captions[$s[1]] = $s[2];
		}
 
		$table = 
				Widget::tableOpen($additionalTags, 'Listagem geral') .
					Widget::tableHeaderOpen() .
						Widget::tableHeaderColumns($captions) .
						Widget::tableBodyOpen() .
							Widget::tableBodyRows($rowsLinks, $model, $columns, $filter) .
						Widget::tableBodyClose() .
					Widget::tableHeaderClose() .
				Widget::tableClose();

		return $table;
	}

}
