jQuery(function($) {

    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }


    $('#veranst-when').daterangepicker({
         "locale": {
        "format": "DD.MM.YYYY",
        "separator": " - ",
        "applyLabel": "w&auml;hlen",
        "cancelLabel": "abbrechen",
        "fromLabel": "Von",
        "toLabel": "Bis",
        "customRangeLabel": "Zeitraum",
        "weekLabel": "W",
        "daysOfWeek": [
            "So",
            "Mo",
            "Di",
            "Mi",
            "Do",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "Januar",
            "Februar",
            "M&auml;rz",
            "April",
            "May",
            "Juni",
            "Juli",
            "August",
            "September",
            "Oktober",
            "November",
            "Dezember"
        ],
        "firstDay": 1
    },
        startDate: start,
        endDate: end,
        ranges: {
           'Heute': [moment(), moment()],
           'Morgen': [moment().add(1, 'days'), moment().add(1, 'days')],
           'n&auml;chste 7 Tage': [moment(), moment().add(6, 'days')],
        },
       
    }, cb);

    cb(start, end);
    
});