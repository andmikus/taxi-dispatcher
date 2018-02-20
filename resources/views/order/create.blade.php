@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">New Order</div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'order.store', 'class' => 'form-horizontal', 'id' => 'order-form']) !!}

                            @include('order.form')

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
    </div>

@endsection

@push('scripts')
    @include('order.scripts')
@endpush