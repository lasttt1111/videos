@section('content')

{{ Form::open(['url' => route('site.postLogin'), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'style="padding-bottom: 20px;
    padding-top: 20px;"']) }}
  <div class="form-icons">
    <h4>Login for vides</h4>

    <div class="input-group">
      <span class="input-group-label">
        <i class="fa fa-envelope"></i>
      </span>
      {{ Form::text('email',  null , ['class' => 'input-group-field', 'placeholder' => 'Email']) }}
    </div>

    <div class="input-group">
      <span class="input-group-label">
        <i class="fa fa-key"></i>
      </span>
      {{ Form::password('password', ['class' => 'input-group-field', 'placeholder' => 'Password']) }}
    </div>
  </div>

  @if($error != '')
  <div class="alert alert-warning">
    <strong>{{ $error }}</strong>
  </div>
  @endif
  
  <button type="submit" class="button expanded">Sign In</button>
  <div style="text-align: center; padding-top: 5px;">

    <a href="{{route('site.register')}}">Register a account</a>
  </div>
 {{ Form::close() }}

@stop