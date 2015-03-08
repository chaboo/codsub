@extends('app')

@section('content')
  <h1>Get our newsletter</h1>
  <p>Want the latest and greatest from our blog straight to your inbox? Send us your details and get a sweet weekly email.</p>
  {!! Form::open(['url' => '/']) !!}
    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
      {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Your first name', 'pattern'=>'[a-zA-Z]+']) !!}
      <span class="help-block">{{ $errors->first('first_name') }}</span>
    </div>
    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
      {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Your last name', 'pattern'=>'[a-zA-Z]+']) !!}
      <span class="help-block">{{ $errors->first('last_name') }}</span>
    </div> 
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
      {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Your email', 'required' => 'true']) !!}
      <span class="help-block">{{ $errors->first('email') }}</span>
    </div>
    <div class="form-group">
      {!! Form::submit('Subscribe', ['class' => 'btn btn-primary btn-block btn-lg']) !!}
    </div>
  {!! Form::close() !!}
@endsection
