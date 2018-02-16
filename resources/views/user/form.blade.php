<div class="form-group row">
    <label for="password" class="col-lg-4 col-form-label text-lg-right">User type</label>

    <div class="col-lg-6">
        <div class="form-check form-check-inline pt-2">

            {!! Form::radio('type',
                                'dispatcher',
                                (old('type') == 'dispatcher'),
                                ['id' => 'inlineRadio1', 'class' => 'form-check-input']
                                )
            !!}
            <label class="form-check-label" for="inlineRadio1">Dispatcher</label>
        </div>
        <div class="form-check form-check-inline pt-2">
            {!! Form::radio('type',
                                'driver',
                                (old('type', 'driver') == 'driver'),
                                ['id' => 'inlineRadio2', 'class' => 'form-check-input']
                                )
                !!}
            <label class="form-check-label" for="inlineRadio2">Driver</label>
        </div>
        @if ($errors->has('password'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </div>
        @endif
    </div>
</div>