<div class="form-group row">
    <label for="origin_address" class="col-lg-4 col-form-label text-lg-right">Origin address</label>
    <div class="col-lg-6">
        {!! $autocompleteHelper->renderHtml($origAutocomplete); !!}
        {!! Form::hidden('origin_location', old('origin_location'), ['id' => 'origin-location']) !!}
        <span class="valid-feedback" id="origin-location-feedback">{{ old('origin_location') }}</span>
        @if ($errors->has('origin_address'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('origin_address') }}</strong>
            </span>
        @endif
        @if ($errors->has('origin_location'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('origin_location') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group row">
    <label for="destination_address" class="col-lg-4 col-form-label text-lg-right">Destination address</label>
    <div class="col-lg-6">
        {!! $autocompleteHelper->renderHtml($destAutocomplete); !!}
        {!! Form::hidden('destination_location', old('destination_location'), ['id' => 'destination-location']) !!}
        <span class="valid-feedback" id="destination-location-feedback">{{ old('destination_location') }}</span>
        @if ($errors->has('destination_address'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('destination_address') }}</strong>
            </span>
        @endif
        @if ($errors->has('destination_location'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('destination_location') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('start_time') ? ' :invalid' : '' }} row">
    <label for="name" class="col-lg-4 col-form-label text-lg-right">Set time</label>
    <div class="col-lg-6">
        {!! Form::text(
                    'start_time',
                    old('start_time', Carbon\Carbon::now()->format('H:i')),
                    [
                        'class' => 'form-control' . ($errors->has('start_time') ? ' is-invalid' : ''),
                        'pattern' => "^([0-1][0-9]|2[0-3]):[0-5][0-9]$",
                        'title' =>  "Please provide correct time format: HH:mm",
                        'autocomplete' => "off",
                        'required'
                    ])
        !!}

        @if ($errors->has('start_time'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('start_time') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('passenger_phone') ? ' :invalid' : '' }} row">
    <label for="name" class="col-lg-4 col-form-label text-lg-right">Passenger phone</label>
    <div class="col-lg-6">
        {!! Form::text(
                    'passenger_phone',
                    old('passenger_phone'),
                    [
                        'class' => 'form-control' . ($errors->has('passenger_phone') ? ' is-invalid' : ''),
                    ])
        !!}

        @if ($errors->has('passenger_phone'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('passenger_phone') }}</strong>
            </span>
        @endif
    </div>
</div>

{!! $apiHelper->render([$origAutocomplete, $destAutocomplete]); !!}

@isset($order)
    {!! Form::hidden('driver_id', $order->driver_id) !!}
@endisset

<div class="row justify-content-center">
    <div class="col-md-8">
        <p>Drivers</p>
        {!! $dataTable->table() !!}
    </div>
</div>