@section('content')

{{ Form::open(['url' => route('site.postRegister'), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'style="padding-bottom: 20px;
    padding-top: 20px;"']) }}
  <div class="form-icons">
    <h4>Register for an account</h4>
    @if ($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
    @endif    
    <div class="input-group">
      <span class="input-group-label">
        <i class="fa fa-user"></i>
      </span>
      {{ Form::text('name',  null , ['class' => 'input-group-field', 'placeholder' => 'Full name']) }}
    </div>

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

    <div class="input-group">
      <span class="input-group-label">
        <i class="fa fa-key"></i>
      </span>
      {{ Form::password('password_confirmation', ['class' => 'input-group-field', 'placeholder' => 'Password Confirmation']) }}
    </div>

    <div class="large-12 columns" style="margin-bottom: 10px;">
      {!! Recaptcha::render() !!}
    </div>

  </div>

  <button type="submit" class="button expanded">Sign Up</button>
 {{ Form::close() }}


@stop