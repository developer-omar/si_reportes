$(document).ready(function () {
    $('#company_institution').change(function(event) {
        let id = $(this).val();
        if(id != '') {
            $.getJSON(`/administracion/empresas-instituciones/${id}/sucursales`, {},
                function (response) {
                    let subsidiaries = response;
                    let options = `<option value="">Sucursal</option>`;
                    $.each(subsidiaries, function (index, subsidiary) {
                        options += `<option value="${subsidiary.id}">
                                        ${subsidiary.name} (${subsidiary.city.name})
                                    </option>`
                    });
                    $("#subsidiary").html(options);
                }
            );
        } else {
            $("#subsidiary").html(
                `<option value="">Sucursal</option>`
            );
        }
    });

    $('#created_at').mask('99/99/9999');
});
