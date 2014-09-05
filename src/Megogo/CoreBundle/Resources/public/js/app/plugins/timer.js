var timer = new (function() {

    if (typeof($.cookie('currentTime')) != "undefined") {
        var currentTime = $.cookie('currentTime');
    }else {
        var currentTime = 36000;
    }


    var $countdown,
        incrementTime = 70,
        updateTimer = function() {
            $countdown.html(formatTime(currentTime));
            $.cookie('currentTime', currentTime);
            if (currentTime == 0) {
                timer.Timer.stop();
                timerComplete();
                return;
            }
            currentTime -= incrementTime / 10;
            if (currentTime < 0) currentTime = 0;
        },
        timerComplete = function() {
            alert('Time is over. Thank you, for aswers!');
            clearUserData();
        },
        init = function() {
            $countdown = $('#time');
            timer.Timer = $.timer(updateTimer, incrementTime, true);

        };
    $(init);
});

function formatTime(time) {
    return parseInt(time / 100)
}

function clearUserData(){

    var url = $('body').data('clear_session_data_route');

    $.ajax({
        url: url,
        type: "POST",
        data: [],
        dataType: "json",
        success:
            function(result) {
                if (result === 'ok'){
                    $.cookie('currentTime', 36000);
                    window.location.href = $('body').data('homepage_route');
                }
            },
        error:
            function() {

            }
    });
}