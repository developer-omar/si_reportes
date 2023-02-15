@extends('page.layout.app')

@section('content')
    <div class="container">
        <div class="row pb-4">
            <div class="col-12">
                @include('page.report.search-form')
            </div>
        </div>
        @if($reports->count() > 0)
            @foreach($reports as $report)
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-4">
                        <h5>Informe</h5>
                        <p>{{ $report->name  }}</p>
                        <p>{{ $report->created_at->format('d/m/Y')  }}</p>
                        @if($report->equipmentStatus->id == 1)
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i>
                                {{ $report->equipmentStatus->name }}
                            </span>
                        @elseif($report->equipmentStatus->id == 2)
                            <span class="badge badge-warning" style="background-color: #ffc107">
                                <i class="fas fa-eye"></i>
                                {{ $report->equipmentStatus->name }}
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-times"></i>
                                {{ $report->equipmentStatus->name }}
                            </span>
                        @endif
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <h5>Sucursal</h5>
                        <p>{{ $report->subsidiary->name }}</p>
                        <p>{{ $report->subsidiary->city->name }}</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <h5>Emp. / Inst.</h5>
                        <p>{{ $report->subsidiary->companyInstitution->name }}</p>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
                        <div class="container-btn">
                            <a  href="{{ $report->file }}"
                                class="btn btn-secondary btn-pdf"
                                role="button"
                                target="_blank"
                            >
                                <i class="fas fa-file-pdf"></i> Ver PDF
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <br>
            {{ $reports->withQueryString()->links() }}
        @else
            <div class="alert alert-info" role="alert">
                <b>A&uacute;n no se tienen registros de Reportes</b>
            </div>
        @endif
    </div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/page/reports_index.css') }}">
    <style>
        .body {
            position: relative;
            overflow: hidden;
        }

        .body:before{
            content: ' ';
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.04;
            background-image: url("{{ asset('img/inbustrade.jpg') }}");
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }
    </style>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/lib/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/page/reports_index.js') }}"></script>
@endsection
