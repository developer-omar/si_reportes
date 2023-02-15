@extends(
    'administration.common.card-form'
)

@section('form')
    <div class="row">
        <div class="col-md-4 text-center">
            @if(!empty($companyInstitution))
                <img    src="{{ $companyInstitution->photo }}"
                        alt="{{ $companyInstitution->name }}"
                        class="logo"
                >
            @else
                <div class="preview" id="div-logo">
                    <span>Logo</span>
                </div>
                <img    src=""
                        alt="Logo"
                        style="display: none;"
                        id="img-logo"
                >
            @endif

        </div>
        <div class="col-md-8">
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
                            value="{{ $companyInstitution->name ?? '' }}"
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
                    <label for="photo">Foto</label>
                    <input  type="file"
                            class="form-control-file {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                            name="photo"
                            id="photo"
                            value="{{ $companyInstitution->photo ?? '' }}"
                            aria-describedby="photo"
                    >
                    @error('photo')
                    <div class="invalid-feedback">
                        Seleccione una Foto de tipo JPG o PNG
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ $button }}</button>
            </form>
        </div>
    </div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/administration/companies-institutions_create.css') }}">
@endsection

@section('js')
    @parent
    <script src="{{ asset('js/administration/companies-institutions_create.js') }}"></script>
@endsection
