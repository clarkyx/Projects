<br/>
<h2 class="center">PAYMENT</h2>

<hr/>
<br/>
<p>Please enter the payment details</p>
<br/>
<form action="<?php echo base_url();?>main/summary" method="post" onsubmit="return validateForm()" >
<input type="hidden" name="flight" value="<?php echo $flight; ?>"/>
<input type="hidden" name="seat" value="<?php echo $seat; ?>"/>

<p>
<label for="first">First name: </label>
<input type="text" name="first-name" id="first-name" />
</p>

<p>
<label for="last">Last name: </label>
<input type="text" name="last-name" id="last-name" />
</p>

<p>
<label for="credit-card-number">Credit card number: </label>
<input type="text" name="credit-card-number" id="credit-card-number"/>
</p>

<p>
<label for="expiration-date">Expiration date: </label>
<input type="text" name="expiration-date" id="expiration-date"/>
</p>



<p>
<label>&nbsp;</label>
<input name="" type="submit" value="Payment &gt;&gt;" style="width: 317px;padding:10px;"/>
</p>
</form>

<script type="text/javascript">
function validateForm()
{
if (!$('#first-name').val())
  {
  alert("First name must be filled out");
  return false;
  }  else if (!$('#last-name').val())
  {
  alert("Last name must be filled out");
  return false;
  } else if (!$('#credit-card-number').val() || $('#credit-card-number').val().length != 16 || isNaN($('#credit-card-number').val()) )
  {
  alert("Credit card number must be filled out and valid 16 digit number");
  return false;
  } else if(checkExp()) {
	  alert("Credit card expiration date must be filled out and valid");
  return false;
  }
}

function normalizeYear(year){
    // Century fix
    var YEARS_AHEAD = 20;
    if (year<100){
        var nowYear = new Date().getFullYear();
        year += Math.floor(nowYear/100)*100;
        if (year > nowYear + YEARS_AHEAD){
            year -= 100;
        } else if (year <= nowYear - 100 + YEARS_AHEAD) {
            year += 100;
        }
    }
    return year;
}

function checkExp(){
    var match=$('#expiration-date').val().match(/^\s*(0?[1-9]|1[0-2])\/(\d\d|\d{4})\s*$/);
    if (!match){
        return true;
    }
    var exp = new Date(normalizeYear(1*match[2]),1*match[1]-1,1).valueOf();
    var now=new Date();
    var currMonth = new Date(now.getFullYear(),now.getMonth(),1).valueOf();
    if (exp<=currMonth){
        return true;
    } else {
        return false;
    };
}
</script>


