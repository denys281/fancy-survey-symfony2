MEGOGO.homepage = {

    init: function () {
        $("#js-submit-step-one").on('click', MEGOGO.homepage.saveStepOne);

    },

    saveStepOne: function() {

        var url = $('#js-submit-step-one').data('url');
        var formData = $('#registration').serialize();

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "json",
            success:
                function(result) {
                    if (result === 'ok') {
                       $('#form-container').html($.parseHTML(result.stepOneFormView));
                        $("#js-submit-step-one").on('click', MEGOGO.homepage.saveStepOne);
                    }else if(result.status === 'valid') {
                        $('#form-container') .html($.parseHTML(result.stepTwoFormView));
                        $("#js-submit-step-two").on('click', MEGOGO.step_two.saveStepTwo);
                    }else {
                        alert ('Error save to db')
                    }
                },
            error:
                function() {

                }
        });
    }

}