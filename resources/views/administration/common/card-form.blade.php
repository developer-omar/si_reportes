@extends('administration.layout.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-{{ $cardWidth }}">
            <div class="card">
                <div class="card-header">{!! $title !!}</div>
                <div class="card-body">
                    @yield('form')
                </div>
            </div>
        </div>
    </div>
@endsection
