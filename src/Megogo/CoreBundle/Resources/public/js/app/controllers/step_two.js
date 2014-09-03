MEGOGO.step_two = {

    init: function () {
        $("#js-submit-step-two").on('click', MEGOGO.step_two.saveStepTwo);

    },

    saveStepTwo: function() {

        var url = $('#js-submit-step-two').data('url');
        var formData = $('#stepTwo').serialize();

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "json",
            success:
                function(result) {
                    if (result.status === 'invalid') {
                        $('#form-container').html($.parseHTML(result.stepTwoFormView));
                        $("#js-submit-step-two").on('click', MEGOGO.step_two.saveStepTwo);
                    }else if(result.status === 'valid') {
                        $('#form-container').html($.parseHTML(result.stepThreeView));
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