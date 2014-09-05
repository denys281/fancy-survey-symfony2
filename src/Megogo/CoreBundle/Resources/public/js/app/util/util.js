/** @namespace */
var MEGOGO = {};

// call init function for current route 
$(document).ready(function () {

    if (typeof(MEGOGO[$('body').data('route')]) != "undefined") {
        var route_function = MEGOGO[$('body').data('route')]['init'];
    } else {
        var route_function = '';
    }

    if (route_function && typeof route_function === 'function') {
        route_function();
    }

});