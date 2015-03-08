@extends('app')

@section('content')
  <h2>Almost finished...</h2>
  <br/>
  <p>We need to confirm your address.</p>
  <p>To complete the subscription process, please click the link in the email we just sent you!</p>
  <br/>
  {!! link_to_route('home', 'Return to our website', [], ['class' => 'btn btn-primary']) !!}
@endsection('content')