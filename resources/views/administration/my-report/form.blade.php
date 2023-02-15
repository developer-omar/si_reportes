@extends(
    'administration.common.card-form'
)

@section('form')
    <form   enctype="multipart/form-data"
            method="POST"
            action="{{ $action }}"
            novalidate
    >
        @csrf
        @if(!empty($method))
            @method($method)
        @endif
        <div class="form-group">
            <label for="name">Nombre</label>
            <input  type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    name="name"
                    id="name"
                    value="{{ $report->name ?? '' }}"
                    autocomplete="off"
                    placeholder="Nombre Informe"
                    aria-describedby="name"
            >
            @error('name')
            <div class="invalid-feedback">
                Ingrese un Nombre de Informe Valido
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="company_institution_id">Empresa / Instituci&oacute;n</label>
            <select     name="company_institution_id"
                        id="company_institution_id"
                        class="form-control {{ $errors->has('company_institution_id') ? 'is-invalid' : '' }}"
            >
                <option value="">Seleccione</option>
                @foreach($companiesInstitutions as $companyInstitution)
                    @if(!empty($report))
                        @if($companyInstitution->id == $report->subsidiary->companyInstitution->id)
                            <option value="{{ $companyInstitution->id }}" selected>{{ $companyInstitution->name }}</option>
                        @else
                            <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                        @endif
                    @else
                        <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('company_institution_id')
                <div class="invalid-feedback">
                    Seleccione una Empresa / Instituci&oacute;n
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="subsidiary_id">Sucursal</label>
            <select     name="subsidiary_id"
                        id="subsidiary_id"
                        class="form-control {{ $errors->has('subsidiary_id') ? 'is-invalid' : '' }}"
            >
                <option value="">Seleccione</option>
                @if(!empty($subsidiaries))
                    @foreach($subsidiaries as $subsidiary)
                        @if($subsidiary->id == $report->subsidiary->id)
                            <option value="{{ $subsidiary->id }}" selected>{{ $subsidiary->name }}</option>
                        @else
                            <option value="{{ $subsidiary->id }}">{{ $subsidiary->name }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            @error('subsidiary_id')
                <div class="invalid-feedback">
                    Seleccione una Sucursal
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="equipment_status_id">Estado del Equipo</label>
            <select     name="equipment_status_id"
                        id="equipment_status_id"
                        class="form-control {{ $errors->has('equipment_status_id') ? 'is-invalid' : '' }}"
            >
                <option value="">Seleccione</option>
                @foreach($equipmentStates as $equipmentStatus)
                    @if(!empty($report))
                        @if($equipmentStatus->id == $report->equipmentStatus->id)
                            <option value="{{ $equipmentStatus->id }}" selected>{{ $equipmentStatus->name }}</option>
                        @else
                            <option value="{{ $equipmentStatus->id }}">{{ $equipmentStatus->name }}</option>
                        @endif
                    @else
                        <option value="{{ $equipmentStatus->id }}">{{ $equipmentStatus->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('equipment_status_id')
                <div class="invalid-feedback">
                    Seleccione un Estado
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="photo">Archivo PDF</label>
            <input  type="file"
                    class="form-control-file {{ $errors->has('file') ? 'is-invalid' : '' }}"
                    name="file"
                    id="file"
                    value="{{ $report->file ?? '' }}"
                    aria-describedby="photo"
            >
            @error('file')
            <div class="invalid-feedback">
                Seleccione una Archivo de tipo PDF
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </form>
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/administration/my-reports_create.js') }}"></script>
@endsection
