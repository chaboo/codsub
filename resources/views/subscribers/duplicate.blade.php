@extends('app')

@section('content')
  <h2>You are already subscribed...</h2>
  <br/>
  <p>Thank you for showing interest into our newsletter twice.</p>
  <br/>
  {!! link_to_route('home', 'Return to our website', [], ['class' => 'btn btn-primary']) !!}
@endsection('content')