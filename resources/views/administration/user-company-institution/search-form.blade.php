
<form action="{{ route('administration.user-company-institution.index') }}" method="GET">
    <div class="row">
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <div class="form-group">
                <input  type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Nombre(s)"
                        value="{{ $searchForm['name'] ?? '' }}"
                        autocomplete="off"
                >
            </div>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <div class="form-group">
                <input  type="text"
                        name="last_name"
                        id="last_name"
                        class="form-control"
                        placeholder="Apellido(s)"
                        value="{{ $searchForm['last_name'] ?? '' }}"
                        autocomplete="off"
                >
            </div>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <select name="company_institution" id="company_institution" class="form-control">
                <option value="">Emp. / Inst.</option>
                @foreach($companiesInstitutions as $companyInstitution)
                    @if(!empty($searchForm['company_institution']))
                        @if($companyInstitution->id == $searchForm['company_institution'])
                            <option value="{{ $companyInstitution->id }}" selected>{{ $companyInstitution->name }}</option>
                        @else
                            <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                        @endif
                    @else
                        <option value="{{ $companyInstitution->id }}">{{ $companyInstitution->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-6">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar
            </button>
            <a class="btn btn-primary" href="{{ route('administration.user-company-institution.index') }}" role="button">
                <i class="fas fa-sync-alt"></i>
                Resetear
            </a>
        </div>
    </div>
</form>
