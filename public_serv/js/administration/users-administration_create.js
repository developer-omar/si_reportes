$(document).ready(function () {
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        prevStepWizard.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function(){
        console.log("entra aqui");
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');

    //switch to role user
    $('#userRole').click(function(event) {
        $('#reportPermissions').prop('checked', true)
            .prop('disabled', false);
        $('#companyInstitutionPermissions').prop('checked', false)
            .prop('disabled', false);
        $('#subsidiaryPermissions').prop('checked', false)
            .prop('disabled', false);
    });

    //switch to role administrator
    $('#administratorRole').click(function(event) {
        $('#reportPermissions').prop('checked', true)
            .prop('disabled', true);
        $('#companyInstitutionPermissions').prop('checked', true)
            .prop('disabled', true);
        $('#subsidiaryPermissions').prop('checked', true)
            .prop('disabled', true);
    });

    //enable password for update
    $('#swEnablePassword').click(function(event) {
        if($(this).prop("checked") == true)
            $('#password').prop('disabled', false);
        else
            $('#password').prop('disabled', true);
    });
});
