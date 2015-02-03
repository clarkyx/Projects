<br/>
<h2 class="center">SEAT RESERVATION</h2>
<hr/>
<br/>
<p>Please select the seat that you want to reserve and click pay button</p>
<br/>
<form action="<?php echo base_url();?>main/payment" method="post">
  <input type="hidden" name="flight" value="<?php echo $flight; ?>"/>
  <p>
    <label for="departure-campus">Seat: </label>
    <select name="seat" id="seatSelect">
      <?php
if($seats[0]) {?>
      <option value="1">Seat 1</option>
      <?php } 

if($seats[1]) {?>
      <option value="2">Seat 2</option>
      <?php } 

if($seats[2]) {?>
      <option value="3">Seat 3</option>
      <?php } ?>
    </select>
  </p>
  <div style="background-image:url(<?php echo base_url();?>images/flight.png);width: 300px; background-repeat: no-repeat; height: 400px;margin-left: 400px;">
    <div style="padding-left: 45px; padding-top: 193px;">
      <button type="button" id="seat1" class="seat" style="padding: 15px 25px; <?php if($seats[0]) { echo 'background-color:#fff;';} else { echo 'background-color: #FFFF00'; } ?>" <?php if(!$seats[0]) { echo 'disabled'; } ?> onclick="selectSeat(1);">&nbsp;</button>
      <button type="button" id="seat2" class="seat" style="padding: 15px 25px; <?php if($seats[1]) { echo 'background-color:#fff;';} else { echo 'background-color: #FFFF00'; } ?>" <?php if(!$seats[1]) { echo 'disabled'; } ?> onclick="selectSeat(2);">&nbsp;</button>
      <button type="button" id="seat3" class="seat" style="padding: 15px 25px; <?php if($seats[2]) { echo 'background-color:#fff;';} else { echo 'background-color: #FFFF00'; } ?>" <?php if(!$seats[2]) { echo 'disabled'; } ?> onclick="selectSeat(3);">&nbsp;</button>
    </div>
  </div>
  <p>
    <label for="departure-campus">&nbsp;</label>
    <input name="" type="submit" value="Pay &gt;&gt;" style="width: 317px;padding:10px;"/>
  </p>
</form>
<script type="text/javascript">
$("#seatSelect").change(function() {
    selectSeat(this.value);
});

function selectSeat(seatNo) {
	$('#seatSelect').val(seatNo);
	$('.seat').each(function() {
		if(!$(this).is(":disabled")) {
			if($(this).attr('id') != ('seat' + seatNo)) {
				$(this).css('background-color', '#FFF');
			} else {
				$(this).css('background-color', '#00FF00');
			}
		}
	});
	
	
}
</script> 
