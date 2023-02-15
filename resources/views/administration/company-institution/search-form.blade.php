<form action="{{ route('administration.company-institution.index') }}" method="GET">
    <div class="row">
        <div class="p-2 p-lg-1 col-12 col-lg-4">
            <div class="form-group">
                <input  type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Nombre Empresa / Institucion"
                        value="{{ $searchForm['name'] ?? '' }}"
                        autocomplete="off"
                >
            </div>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-8">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar
            </button>
            <a class="btn btn-primary" href="{{ route('administration.company-institution.index') }}" role="button">
                <i class="fas fa-sync-alt"></i>
                Resetear
            </a>
        </div>
    </div>
</form>
