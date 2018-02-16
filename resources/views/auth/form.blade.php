<div class="form-group row">
    <label for="name" class="col-lg-4 col-form-label text-lg-right">Name</label>

    <div class="col-lg-6">
        {!! Form::text(
                    'name',
                    old('name'),
                    [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'required'
                    ])
        !!}

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' :invalid' : '' }} row">
    <label for="email" class="col-lg-4 col-form-label text-lg-right">E-Mail Address</label>

    <div class="col-lg-6">
        {!! Form::email(
                    'email',
                    old('email'),
                    [
                        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                        'required'
                    ])
        !!}

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-lg-4 col-form-label text-lg-right">Password</label>

    <div class="col-lg-6">
        {!! Form::password(
                        'password',
                        [
                            'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                            'required'
                        ])
        !!}

        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-lg-4 col-form-label text-lg-right">Confirm Password</label>

    <div class="col-md-6">
        {!! Form::password( 'password_confirmation', ['class' => 'form-control', 'required']) !!}
    </div>
</div>