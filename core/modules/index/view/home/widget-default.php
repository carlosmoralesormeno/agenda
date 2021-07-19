<?php
date_default_timezone_set('America/Manaus');
$today = date("Y-m-d"); // Use this format
$hours = date("H:i:s"); // Use this format


$events = EventData::getEvery();
foreach($events as $event){

    switch ($event->project_id) {
        case '1':
            $color="rgb(181 18 73)";
            break;
        case '2':
            $color="rgb(200 120 0)";
            break;
        case '3':
            $color="rgb(0 150 170)";
            break;
        default:
            $color="rgb(82 88 92)";
            break;
    }

	$thejson[] = array("id"=>$event->id,"title"=>$event->title,"description"=>$event->description,"color"=>$color,"url"=>"./?view=editreservation&id=".$event->id,"start"=>$event->date_at."T".$event->time_at, "end"=>$event->date_at."T".$event->time_end);
	
}
// print_r(json_encode($thejson));

?>
<script>
$(document).ready(function() {

    $('#calendar').fullCalendar({
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
            'Dic'
        ],
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ],
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        allDaySlot: false,
        firstDay: 1,
        businessHours: {
            dow: [1, 2, 3, 4, 5],
            start: '08:00',
            end: '20:00',
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        slotLabelFormat: "HH:mm",
        timeFormat: 'HH:mm',
        minTime: '08:00:00',
        maxTime: '20:00:00',
        defaultView: 'agendaWeek',
        slotDuration: '00:15:00',
        nowIndicator: true,
        now: <?php echo "'" . $today ."T".$hours. "'"; ?>,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: <?php echo json_encode($thejson); ?>,
        eventDrop: function(event, delta, revertFunc) {
            edit_event_ajax(event.id, event.start.format('Y-MM-DD'), event.start.format('HH:mm'), event.end
                    .format('HH:mm'));

        },
        eventResize: function(event, delta, revertFunc) {
            edit_event_ajax(event.id, event.start.format('Y-MM-DD'), event.start.format('HH:mm'), event.end
                    .format('HH:mm'));
        }

    });

});
</script>

<a href="index.php?view=newreservation" class="btn btn-primary pull-right"><i class="fa fa-asterisk"></i> Nueva
    Reserva</a>

<div class="row">
    <div class="col-md-12">
        <h1>Calendario</h1>
        <div id="calendar"></div>
    </div>
</div>