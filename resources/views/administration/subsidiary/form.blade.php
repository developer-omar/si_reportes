@extends(
    'administration.common.card-form',
    [
        'title' => $title
    ]
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
                    value="{{ $subsidiary->name ?? '' }}"
                    autocomplete="off"
                    placeholder="Nombre"
                    aria-describedby="name"
            >
            @error('name')
            <div class="invalid-feedback">
                Ingrese un Nombre Valido
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
                    @if(!empty($subsidiary))
                        @if($companyInstitution->id == $subsidiary->company_institution_id)
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
            <label for="city_id">Ciudad</label>
            <select     name="city_id"
                        id="city_id"
                        class="form-control {{ $errors->has('city_id') ? 'is-invalid' : '' }}"
            >
                <option value="">Seleccione</option>
                @foreach($cities as $city)
                    @if(!empty($subsidiary))
                        @if( $city->id == $subsidiary->city_id)
                            <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                        @else
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endif
                    @else
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">
                    Seleccione una Ciudad
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </form>
@endsection
