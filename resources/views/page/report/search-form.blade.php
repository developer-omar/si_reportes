<form   action="{{
                route(
                    'page.report.index'
                )
        }}"
        method="GET"
>
    <div class="row">
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <input  type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    placeholder="Nombre Informe"
                    value="{{ $searchForm['name'] ?? '' }}"
                    autocomplete="off"
            >
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <input  type="text"
                    name="created_at"
                    id="created_at"
                    class="form-control"
                    placeholder="Fecha"
                    value="{{ $searchForm['created_at'] ?? '' }}"
                    autocomplete="off"
            >
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <select name="subsidiary" id="subsidiary" class="form-control">
                <option value="">Sucursal</option>
                @foreach($subsidiaries as $subsidiary)
                    @if(!empty($searchForm['subsidiary']))
                        @if($subsidiary->id == $searchForm['subsidiary'])
                            <option value="{{ $subsidiary->id }}" selected>{{ $subsidiary->name }} ({{ $subsidiary->city->name }})</option>
                        @else
                            <option value="{{ $subsidiary->id }}">{{ $subsidiary->name }} ({{ $subsidiary->city->name }})</option>
                        @endif
                    @else
                        <option value="{{ $subsidiary->id }}">{{ $subsidiary->name }} ({{ $subsidiary->city->name }})</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-2">
            <select name="equipment_status" id="equipment_status" class="form-control">
                <option value="">Estado del Equipo</option>
                @foreach($equipmentStates as $equipmentStatus)
                    @if(!empty($searchForm['equipment_status']))
                        @if($equipmentStatus->id == $searchForm['equipment_status'])
                            <option value="{{ $equipmentStatus->id }}" selected>{{ $equipmentStatus->name }}</option>
                        @else
                            <option value="{{ $equipmentStatus->id }}">{{ $equipmentStatus->name }}</option>
                        @endif
                    @else
                        <option value="{{ $equipmentStatus->id }}">{{ $equipmentStatus->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="p-2 p-lg-1 col-12 col-lg-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar
            </button>
            <a  class="btn btn-primary"
                href="{{
                        route(
                            'page.report.index'
                        )
                      }}"
                role="button"
            >
                <i class="fas fa-sync-alt"></i>
                Resetear
            </a>
        </div>
    </div>
</form>
