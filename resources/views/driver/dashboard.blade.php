@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">

                        @include('driver.shift')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#in-shift').change(function () {

            var data = $(this).prop('checked') ? 1 : 0;

            $.ajax({
            url: '{{ route('driver.shift') }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'POST',
            data: {'in_shift': data},
            success: function (response) {
                console.log(response);
                }
            });
        });
    </script>
@endpush