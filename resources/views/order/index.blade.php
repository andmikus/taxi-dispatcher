@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Orders</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>
                            {!! link_to_route('order.create', 'New order', null, ['class' => 'btn btn-primary']) !!}
                        </p>

                        {!! $dataTable->table(['class' => 'table table-striped table-bordered', 'cellspacing' => 0]) !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush