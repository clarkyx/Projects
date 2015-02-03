<div id="new-booking" title="Create new booking">
  <form id="target">
  <fieldset>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="text ui-widget-content ui-corner-all" />
    <select id="rooms"></select>
  </fieldset>
  </form>
</div>

<div class="container">
	<button id="month" class="buttonClass">Month</button>
	<button id="week" class="buttonClass">Week</button>
	<button id="day" class="buttonClass">Day</button>
	
	<button id="prevCal" class="buttonClass" style="float:left;"><</button>
	<button id="nextCal" class="buttonClass" style="float:left;">></button>
	<button id="today" class="buttonClass" style="float:left;margin-left:10px;">Today</button>

	<p id='pageTitle' class='center'>jj</p>
</div>



<div id="calendar"></div>

<div id="nextRooms" class='container'>
<?php
	if (!isset($lower_limit)){
		$lower_limit = 1;
		$view = 'month';
	}else{	
		$view = 'resourceDay';
	}

	if(!isset($go_date)){
		$date = date("d m Y");
	}else{
		$date = $go_date;
	}


	$hidden = array("date" => "$date");
	$prev_limit = $lower_limit - 12;

	if ($lower_limit < 24){
		echo form_open("main/next/$lower_limit", '', $hidden);
		$js = "class='buttonClass'";
		echo form_submit("Next", " >>", $js);
		echo form_close();
	}

	if ($lower_limit > 1){
		echo form_open("main/next/$prev_limit", '', $hidden);
		$js = "class='buttonClass' style=float:left;";
		echo form_submit("Prev", " <<", $js);
		echo form_close();
	}
?>
</div>
<input id="lower_limit" type="hidden" value="<?php echo $lower_limit ?>"></input>
<input id="view" type="hidden" value="<?php echo $view ?>"></input>
