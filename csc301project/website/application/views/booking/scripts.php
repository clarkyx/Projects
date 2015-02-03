<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery.timepicker.min.js"></script>

<script>

$( document ).ready(function () {
	$( "#tmp_freq" ).val( $( "#repeat_freq" ).val());
	$( "#tmp_end" ).val( $( "#repeat_end" ).val());
});

$(function() {
	$( "#start_picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#end_picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#start_time" ).timepicker({ 'timeFormat': 'H:i:s', 'scrollDefaultNow': true });
	$( "#end_time" ).timepicker({ 'timeFormat': 'H:i:s', 'scrollDefaultNow': true });

	$( "#tmp_end" ).datepicker({ dateFormat: 'yy-mm-dd' });

	function checkRegexp(o, regexp, n) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			return false;
		} else {
			return true;
		}
	}

	$( "#repeat" ).change(function () {
		if (this.checked) {
			$( "#repeat-form" ).dialog( "open" );
		}
	});

	var tmp_freq = $( "#tmp_freq" ),
	    tmp_end = $( "#tmp_end" ),
	    repeat_freq = $( "#repeat_freq" ),
	    repeat_end = $( "#repeat_end" ),
	    allFields = $( [] ).add( repeat_freq ).add( repeat_end );
	$( "#repeat-form" ).dialog({
		autoOpen: false,
		height: "auto",
		width: "auto",
		buttons: {
			"Save": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );

				bValid = bValid && checkRegexp(tmp_freq, /^\d+$/i, "e.g. 7");

				if (bValid) {
					repeat_freq.val(tmp_freq.val());
					repeat_end.val(tmp_end.val());
					$( this ).dialog( "close" );
				}
			}
		},
		close: function() {
			allFields.removeClass( "ui-state-error" );
		}
	});

	$( "#target" ).submit(function (e) {
		$( "#repeat-form button" ).click();
		return false;
	});

});


</script>
