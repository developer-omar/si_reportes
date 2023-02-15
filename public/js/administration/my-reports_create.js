$(document).ready(function () {
    $("#company_institution_id").on('change', function(event) {
        let id = $(this).val();
        if(id != '') {
            $.getJSON(`/administracion/empresas-instituciones/${id}/sucursales`, {},
                function (response) {
                    let subsidiaries = response;
                    let options = `<option value="">Selecione</option>`;
                    $.each(subsidiaries, function (index, subsidiary) {
                         options += `<option value="${subsidiary.id}">
                                        ${subsidiary.name} (${subsidiary.city.name})
                                     </option>`
                    });
                    $("#subsidiary_id").html(options);
                }
            );
        } else {
            $("#subsidiary_id").html(
                `<option value="">Selecione</option>`
            );
        }

    });
});
