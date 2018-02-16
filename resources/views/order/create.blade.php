@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">New Order</div>

                    {!! Form::open(['route' => 'order.store', 'class' => 'form-horizontal']) !!}
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="start_address" class="col-lg-4 col-form-label text-lg-right">Origin address</label>
                                <div class="col-lg-6">
                                    {!! $autocompleteHelper->render($origAutocomplete); !!}
                                    @if ($errors->has('start_address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('start_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="end_address" class="col-lg-4 col-form-label text-lg-right">Destination address</label>
                                <div class="col-lg-6">
                                    {!! $autocompleteHelper->render($destAutocomplete); !!}
                                    @if ($errors->has('end_address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('end_address') }}</strong>
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

                        </div>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p>Drivers</p>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-right">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            {!! Form::reset('Reset', ['class' => 'btn']) !!}
                        </li>
                    </ul>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    {!! $autocompleteHelper->renderJavascript($origAutocomplete); !!}
    {!! $autocompleteHelper->renderJavascript($destAutocomplete); !!}
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
    </script>

@endpush