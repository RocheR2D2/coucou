$(document).ready(function() {
    var calendar =  $('#calendar');
    var newDate = new Date();
    var d = newDate.getDate();
    var m = newDate.getMonth();
    var y = newDate.getFullYear();

    calendar.fullCalendar({
        header: {
            left: 'month',
            center: 'title',
            right: 'prev,next'
        },
        handleWindowResize: true,
        editable: false,
        selectable: false,

        dayClick: function(date) {

           var todayFr = currentDayFr();
           var isweekend = false;
            var checkDay = new Date($.fullCalendar.formatDate(date, 'YYYY-MM-DD'));
            if (checkDay.getDay() === 6 || checkDay.getDay() === 0){
                isweekend = true;
            }
            var events = $('#calendar').fullCalendar('clientEvents', function(event) {
                var eventStart = event.start.format('YYYY-MM-DD');
                var eventEnd = event.end ? event.end.format('YYYY-MM-DD') : null;
                var theDate = date.format('YYYY-MM-DD');
                // Make sure the event starts on or before date and ends afterward
                // Events that have no end date specified (null) end that day, so check if start = date
                return (eventStart <= theDate && (eventEnd >= theDate) && !(eventStart < theDate && (eventEnd == theDate))) || (eventStart == theDate && (eventEnd === null));
            });

            launchModal(date, events, todayFr, isweekend);

        },
        /*
         *  eventClick active the same function as dayClick
         */
        eventRender: function (event, element) {
            $(element).addClass('clickThrough');
        },
        /*
         *  load events from database by ajax
         */

        events:
            /*
            {
                title: 'Validé',
                start: new Date(y, m, d, 0, 0),
                end: new Date(y, m, d, 0, 0)

            },

            {
                title: 'Validé',
                start: new Date(y, m, d, 0, 0),
                end: new Date(y, m, d, 0, 0)
            },
            */

            function(start, end, timezone, callback) {

                $.ajax({
                    url: Routing.generate('loadEvent'),
                    type:'post',
                    data:'date',
                    contentType: "application/json;charset:utf-8",
                    dataType: "json",
                    success: function(data) {
                        var events = [];

                        var titles = [ 'Undefined',
                            'Congés Payés/RTT', 'Maladie', 'Déplacement',
                            'Absence Prestation', 'Télé travail',
                            'Astreinte', 'Congés Prévisionnels',
                            '4/5', 'Formation', 'Ecole/Contrat Pro',
                            'Evènement Famillial', 'Heures Supp'
                        ];
                        var status =  ['En Cours', 'Validé', 'Refusé'];
                        var allDays = ['Journée complète', 'Matinée', 'Après-midi'];
                        var colors = ["#f7b543","#5cb45b", "#d9534f"]; // En Cours,  Validé, Refusé

                        for(var i=0; i<data.length; i++) {
                            events.push({
                                title: '[Raison]: '+ titles[data[i].title] + '\n[Status]: ' + status[data[i].valide] + '\n[Type]: ' + allDays[data[i].allday] ,
                                start: data[i].startTime.date,
                                end: data[i].endTime.date,
                                color: colors[data[i].valide]
                            });
                        }

                        callback(events);
                    }
                });
            }



    });

    function launchModal(date, events, todayFr, isweekend) {

        var startDateformat = date.format('DD-MM-YYYY');
        var nbEvents = events.length;
        $('#titleDate').html('<span class="label label-darkgreen"> Date: ' + startDateformat + '</span><span class="label label-darkblue" style="margin-left: 20px;">Evènements: ' + nbEvents + '</span><span class="label label-dark" style="margin-left: 20px;">Today: ' + todayFr + '</span>');
        $('#cancel').click(initModal());
        $('#close').click(initModal());
        $('.displayEventModal').modal();

        if(isweekend == true) {

            var weekendmessage = '<div class="alert alert-warning text-center"><h4>Bon Weekend !</h4></div>';
            $('#eventmessage').show().html(weekendmessage);
            $('#addEvent').hide();
        }else{

            var videmessage = '<div class="alert alert-warning"><b><i class="fa fa-warning"></i></b> Vous n\'avez déposé aucun congé!</div>';
            // Compare the date by standard format MM-DD-YYYY
            if(smallerthantoday(date)) {

                $('#addEvent').hide();

                if(nbEvents != 0) {

                    $('#eventmessage').show().html('<div class="alert alert-danger"><b><i class="fa fa-times-circle"></i></b> Vous pouvez rien déposer dans le passé!</div>');
                    var eventTable = CreateListTable(events, 4, $('#eventslist') );
                    eventTable.show();

                }else{

                   $('#eventmessage').show().html(videmessage + '<div class="alert alert-danger"><b><i class="fa fa-times-circle"></i></b> Vous pouvez rien déposer dans le passé!</div>');

                }

            }else{

                if(nbEvents != 0) {

                    var eventTable = CreateListTable(events, 4, $('#eventslist') );
                    eventTable.show();

                }else{

                    $('#eventmessage').show().html(videmessage);

                }

                if(nbEvents < 2) {
                    $('#addEvent').show().on('click', function() {

                        $('#addEvent').hide();
                        $('#eventslist').hide();
                        $('#newEventForm').show();
                        $('#addSubmit').show();

                        var startTime = $('#startTime');
                        var endTime = $('#endTime');

                        startTime.val(date.format('DD/MM/YYYY'));

                        endTime.on('changeDate',function(e) {

                            if(startTime.val() === endTime.val()) {
                                $('.radio-choice').show();
                                $('.radio-choice-info').hide();

                            }else{
                                $('.radio-choice').hide();
                                $('.radio-choice-info').show();
                            }
                        });


                    });

                    $('#addSubmit').on('click',function() {
                        var form = $('#add_form');

                        $.ajax({
                            url: form.attr('action'),
                            method: form.attr('method'),
                            data: form.serialize(),
                            dataType: 'json',
                            contentType: "application/json; charset=utf-8",
                            async: true,
                            success: function(data) {
                                form[0].reset();
                                $('#calendar').fullCalendar('refetchEvents');


                            },
                            error: function(xhr, status, error) {

                            }


                        });
                    });
                }else{
                    $('#addEvent').hide();
                }


            }
        }







    }

    function initModal() {
        $('#addEvent').show();
        $('#addSubmit').hide();
        $('#newEventForm').hide();
        $('#eventslist').show();
        $('#eventmessage').hide();
        $('#eventslist table').remove();
        $('#add_form')[0].reset(); // Init form value
        $('.radio-choice').hide();
        $('.radio-choice-info').hide();
        $('#endTime').val("").datepicker("update"); // Init Date picker date value

    }

    function currentDayFr() {

        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var year = d.getFullYear();

        return  ((''+day).length<2 ? '0' : '') + day + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + year;

    }

    function smallerthantoday(date) {

        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();

        var today = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        var dateformat = date.format('YYYY/MM/DD');

        if(today > dateformat){
            return true;
        }
        return false;

    }

    function CreateListTable(events,element, eventslist)
    {

        var table=$("<table class='table'><tr><th>Titre</th><th>Rasion</th><th>Status</th><th>Action</th></tr>");
        table.appendTo(eventslist);
        for(var i=0;i<events.length;i++)
        {
            var tr=$("<tr></tr>");
            tr.appendTo(table);
            for(var j=0;j<element-1;j++)
            {
                var td=$("<td>"+j+"</td>");
                td.appendTo(tr);
            }
            var actions = $("<td><button class='btn btn-xs btn-success btn-square' data-toggle='tooltip' title='Annuler'><i class='mdi mdi-backup-restore'></i></button> <button class='btn btn-xs btn-warning btn-square'  data-toggle='tooltip' title='Modifier'><i class='mdi mdi-pencil'></i></button> <button class='btn btn-xs btn-danger btn-square'><i class='mdi mdi-delete-forever'  data-toggle='tooltip' title='Supprimer'></i></button></td>");
            actions.appendTo(tr);
        }
        tr.appendTo(table);
        eventslist.append("</table>");
        return eventslist;
    }





});