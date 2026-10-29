require('./bootstrap');

import $ from 'jquery';

window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js'

$('.datepicker').datepicker({
    dateFormat: "dd-mm-yy",
    changeYear: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    firstDay: 1,
    minDate: -365 * 80
});

window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
    })
}, 2000);

window.Vue = require('vue');
