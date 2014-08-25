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
                    if (result.status === 'error') {
                        $('#form-container').html($.parseHTML(result.html));
                        $("#js-submit-step-one").on('click', MEGOGO.homepage.saveStepOne);
                    }
                },
            error:
                function() {
//                    mainFunction.error('Извините, произошла ошибка.');
                }
        });
    }

}