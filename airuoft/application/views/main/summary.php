<br/>
<h2 class="center">SUMMARY</h2>

<hr/>
<br/>
<p>Please click print button to print the summary</p>
<br/>

<form>
<p>
<label for="first">Flight id: </label>
<input type="text" name="flight" value="<?php echo $flight; ?>" readonly="readonly"/>
</p>

<p>
<label for="first">Seat No: </label>
<input type="text" name="seat" value="<?php echo $seat; ?>" readonly="readonly"/>
</p>

<p>
<label for="first">First name: </label>
<input type="text" name="first-name" value="<?php echo $first; ?>" readonly="readonly"/>
</p>

<p>
<label for="first">Last name: </label>
<input type="text" name="last-name" value="<?php echo $last; ?>" readonly="readonly"/>
</p>

<p>
<label for="print">&nbsp;</label>
<button type="button"  onclick="window.print();" style="padding: 10px; width: 313px;">Print</button>
</p>
</form>



