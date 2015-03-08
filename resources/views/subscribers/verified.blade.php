@extends('app')

@section('content')
  <h2>Subscription confirmed</h2>
  <br/>
  <p>Your subscription to our list has been confirmed.</p>
  <br/>
  <p>Thank you for subscribing!</p>
  <br/>
  {!! link_to_route('home', 'Continue to our website', [], ['class' => 'btn btn-primary']) !!}
@endsection('content')