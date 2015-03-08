<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateSubscriberRequest;
use App\Subscriber;
use Mail;

class SubscribersController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('subscribers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateSubscriberRequest $request, Subscriber $subscriber)
	{
		$email = $request->get('email');
		$existing = Subscriber::whereEmail($email)->first();
		
		if ($existing) {
			$s = $existing;
			$status = $existing->verified ? 3: 2;
			if ($status === 2) {
				$s->verification_token = str_random(30);
				$s->save();

				$view = 'verify';
				$views = [
	        'emails.'.$view.'_html',
	        'emails.'.$view.'_text',
	      ];

				Mail::queue($views, compact('s'), function($message) use ($s) {
					$message->to($s->email, $s->name())->subject('Please verify your subscription!');
				});
			}
			else {
				$view = 'notify';
				$views = [
	        'emails.'.$view.'_html',
	        'emails.'.$view.'_text',
	      ];

				Mail::queue($views, compact('s'), function($message) use ($s) {
					$message->to($s->email, $s->name())->subject('You are already subscribed!');
				});
			}

		}
		else {
			$status = 1;
			$view = 'verify';
			$views = [
        'emails.'.$view.'_html',
        'emails.'.$view.'_text',
      ];

			$s = Subscriber::create([
				'first_name' 					=> $request->get('first_name'),
				'last_name' 					=> $request->get('last_name'),
				'email' 							=> $request->get('email'),
				'verification_token' 	=> str_random(30)
			]);

			Mail::queue($views, compact('s'), function($message) use ($s) {
				$message->to($s->email, $s->name())->subject('Please verify your subscription!');
			});
		}
		
		return view('subscribers.status', compact('status'));
	}

	public function verify($token)
	{
		if ( ! $token) {
			return redirect()->route('home');
		}

		$s = Subscriber::whereVerificationToken($token)->first();

		if (! $s) {
			return redirect()->route('home');
		}

		$s->verified = 1;
		$s->verification_token = null;
		$s->save();

		return view('subscribers.verified');
	}
}
