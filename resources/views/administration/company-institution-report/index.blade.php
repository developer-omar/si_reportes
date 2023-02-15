
@extends('administration.layout.dashboard')

@section('content')
    @include('administration.company-institution-report.section-title')
    <div class="card">
        <div class="card-body">
            @include('administration.company-institution-report.search-form')
            <hr>
            @if($reports->count() > 0)
                @foreach($reports as $report)
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <h5>Informe</h5>
                                </div>
                                <div class="col-6 col-md-6">
                                    <h5>Sucursal</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>{{ $report->name  }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>{{ $report->created_at->format('d/m/Y')  }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
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
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>{{ $report->subsidiary->name }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p><b>{{ $report->subsidiary->companyInstitution->name }}</b></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>{{ $report->subsidiary->city->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="row">
                                <col-12>
                                    <br>
                                </col-12>
                            </div>
                            <div class="row">
                                <div class="col-12">
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
                    </div>
                    <hr>
                @endforeach
                <br>
                {{ $reports->withQueryString()->links() }}
            @else
                <div class="alert alert-info" role="alert">
                    <b>A&uacute;n no se tienen registros de Informes</b>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/lib/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/administration/companies-institutions-reports_index.js') }}"></script>
@endsection
