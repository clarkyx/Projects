<br/>
<h2 class="center">WELCOME TO AIRUOFT FLIGHT BOOKING SYSTEM</h2>
<hr/>
<br/>
<p>Please select departure date and departure campus to find available flights</p>
<br/>
<form action="<?php echo base_url();?>main/matchingFlights" method="post">
  <p>
    <label for="departure-campus">Departure date: </label>
    <input type="text" class="datepicker" name="departure-date" />
  </p>
  <p>
    <label for="departure-campus">Departure campus: </label>
    <select name="departure-campus">
      <option value="1">St. George</option>
      <option value="2">Mississauga</option>
    </select>
  </p>
  <p>
    <label for="departure-campus">&nbsp;</label>
    <input name="" type="submit" value="Find availabe flights &gt;&gt;" style="width: 312px;padding:10px;"/>
  </p>
</form>
<script type="text/javascript">
    $(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',  minDate: 1  });
  });
    </script> 
