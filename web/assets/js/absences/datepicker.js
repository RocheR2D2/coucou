$(document).ready(function() {

    var startTime = $('#startTime');
    var endTime = $('#endTime');

    endTime.datepicker({
        daysOfWeekDisabled: [0,6],
        toggleActive: true,
        todayHighlight: true,
        autoclose: true,
        language: 'fr',
        startDate: new Date()
    }).on('click', function(e){
        endTime.datepicker('setStartDate',startTime.val());
    });


});