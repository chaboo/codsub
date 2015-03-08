<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateSubscriptionRequest;

use App\Events\DuplicateSubscriptionWasRequested;

use App\Commands\CreateSubscriptionCommand;
use App\Commands\ReverifySubscriptionCommand;
use App\Commands\VerifySubscriptionCommand;

use App\Subscriber;

use Bus;

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
	public function store(CreateSubscriptionRequest $request)
	{
		$existing = Subscriber::whereEmail($request->get('email'))->first();
		
		// subscription request from already verified subscriber
		if ($existing && $existing->verified) {
			\Event::fire(new DuplicateSubscriptionWasRequested($existing));
			return view('subscribers.duplicate');
		}

		// new subscription request for
		// previously seen but not yet verified subscriber 
		if($existing) {
			Bus::dispatch(new ReverifySubscriptionCommand($request->get('email')));
			return view('subscribers.verify');
		}

		// new subscription request
		Bus::dispatchFrom(CreateSubscriptionCommand::class, $request);
		return view('subscribers.verify');
	}

	public function verify($token)
	{
		if (! $token) {
			return redirect()->route('home');
		}

		$subscriber = Subscriber::whereVerificationToken($token)->first();

		if (! $subscriber) {
			return redirect()->route('home');
		}

		Bus::dispatch(new VerifySubscriptionCommand($subscriber));
		return view('subscribers.verified');
	}
}
