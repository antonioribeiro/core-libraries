<?php

class Date {
	
	public static function long($date)  {
		setlocale(LC_TIME, 'pt_BR.utf8');
		$date = new ExpressiveDate();
		return Date::localize( $date->format('j F Y') . strtolower($date->format(' (l)')) );
	}

	public static function localize($string) {

		$english 	= array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$portuguese	= array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
		$portuguese	= array("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		$portuguese	= array("Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
		$portuguese	= array("jan", "fev", "mar", "abr", "mai", "jun", "jul", "ago", "set", "out", "nov", "dez");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
		$portuguese	= array("Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");
		$portuguese	= array("segunda", "terça", "quarta", "quinta", "sexta", "sábado", "domingo");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
		$portuguese	= array("Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom");
		$string = str_replace($english, $portuguese, $string);		

		$english 	= array("mon", "tue", "wed", "thu", "fri", "sat", "sun");
		$portuguese	= array("seg", "ter", "qua", "qui", "sex", "sáb", "dom");
		$string = str_replace($english, $portuguese, $string);		

		return $string;
	}

}
