@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">Edit User</div>

                    {!! Form::model($user, [
                            'route' => ['user.update', $user],
                            'method' => 'PATCH',
                            'class' => 'form-horizontal'
                        ]) !!}
                    <div class="card-body">

                        @include('auth.form')

                        @if( ! $user->isAdmin())
                            @include('user.form')
                        @endif

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