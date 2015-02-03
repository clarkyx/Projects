<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" />
<link rel="stylesheet" href="<?= base_url() ?>fullcalendar/fullcalendar.css" />
<link rel="stylesheet" href="<?= base_url() ?>css/clientPage.css" />

<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src='<?= base_url() ?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script src='<?= base_url() ?>fullcalendar/fullcalendar.min.js'></script>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        allDayDefault: false,
        //weekends: false,

        height: $(window).height() - 60,

        events: '<?= base_url() ?>main/get_events',

        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
            event.dayDelta = dayDelta;
            event.minuteDelta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/move_event";

            $.ajax({
                url: url,
                data: args,
                type: 'POST'
            });
        },

        eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
            event.dayDelta = dayDelta;
            event.minuteDelta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/resize_event";

            $.ajax({
                url: url,
                    data: args,
                    type: 'POST'
            });
        }
    });
});


</script>

</head>

<body>
  <header>
    <nav>
      <ul>
        <li>
          <a href="#" class="logo-link">
            Storefront Calendar<span id="logo-caret" class="icon"></span>
          </a>
          <ul>
            <li><?= anchor('account/form_new_user', 'Add New User') ?></li>
            <li><?= anchor('account/form_edit_user', 'Edit User') ?></li>
            <li><?= anchor('account/form_new_client', 'Add New Client') ?></li>
            <li><?= anchor('account/form_edit_client', 'Edit Client') ?></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <div id="calendar"></div>

</body>
</html>
