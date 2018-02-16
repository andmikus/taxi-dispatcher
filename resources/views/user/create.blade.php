@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">New User</div>

                    {!! Form::open(['route' => 'user.store', 'class' => 'form-horizontal']) !!}
                    <div class="card-body">


                            @include('auth.form')
                            @include('user.form')
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