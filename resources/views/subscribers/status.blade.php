@extends('app')

@section('content')
  @if ($status === 1 || $status === 2)
    <h2>Almost finished...</h2>
    <br/>
    <p>We need to confirm your address.</p>
    <p>To complete the subscription process, please click the link in the email we just sent you!</p>
    <br/>
    {!! link_to_route('home', 'Return to our website', [], ['class' => 'btn btn-primary']) !!}
  @else ($status === 3)
    <h2>You are already subscribed...</h2>
    <br/>
    <p>Thank you for showing interest into our newsletter twice.</p>
    <br/>
    {!! link_to_route('home', 'Return to our website', [], ['class' => 'btn btn-primary']) !!}
  @endif
@endsection('content')