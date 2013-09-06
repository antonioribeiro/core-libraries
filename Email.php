<?

class Email {

	public static function queue($user, $view, $subject, $viewData = [], $cc = null, $bcc = null) {

		Email::send($user, $view, $subject, $viewData = [], $cc, $bcc);
		
		// $userId = $user->id;

		// $data = compact('userId', 'view', 'subject');

		// Queue::push(function($job) use ($data) {
		// 	$user = Sentry::getUserProvider()->findById($data['userId']);

		// 	Email::send($user, $data['view'], $data['subject']);
		// });

		// Log::info("Mail [$subject] QUEUED to $user->email");

	}

	public static function send($user, $view, $subject, $viewData = [], $cc = null, $bcc = null) {

		Mail::send($view, array_merge(['user' => $user], $viewData), function($message) use ($user, $subject, $cc, $bcc) {

			$message->to($user->email);

			$message->subject($subject);

			if ( !empty($cc))
			{
				$message->cc($cc->email);	
			}

			if ( !empty($bcc))
			{
				$message->bcc($bcc->email);
			}
			
		});

		Log::info("Mail [$subject] SENT to $user->email");

	}

}
