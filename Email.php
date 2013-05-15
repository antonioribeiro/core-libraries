<?

class Email {

	public static function queue($user, $view, $subject) {

		$userId = $user->id;

		$data = compact('userId', 'view', 'subject');

		Queue::push(function($job) use ($data) {
			$user = Sentry::getUserProvider()->findById($data['userId']);

			Email::send($user, $data['view'], $data['subject']);
		});

		Log::info("Mail [$subject] QUEUED to $user->email");

	}

	public static function send($user, $view, $subject) {

		Mail::send($view, ['user' => $user], function($m) use ($user, $subject) {
			$m->to($user->email)->subject($subject);
		});

		Log::info("Mail [$subject] SENT to $user->email");

	}

}
