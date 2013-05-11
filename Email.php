<?

class Email {

	public static function send($user, $view, $subject) {

		Mail::send($view, array('user' => $user), function($m) use ($user, $subject) {
		    $m->to($user->email)->subject($subject);
		});

	}

}
