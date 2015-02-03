<?php
/*
 * Initialization code used later.
 */
$colours = array(
	'red' => 'red',
	'blue' => 'blue',
	'green' => 'green'
);

$user = $this->session->userdata('user');
?>
<div id="repeat-form" title="Repeat...">
	<form id="target">
		<label for="tmp_freq">Frequency</label>
		<input id="tmp_freq" type="text" name="tmp_freq" class="ui-widget-content ui-corner-all" />
		<br />
		<label for="tmp_end">Repeat End Date</label>
		<input id="tmp_end" type="text" name="tmp_end" class="ui-widget-content ui-corner-all" />
	</form>
</div>

<table width="auto" class="outter">
	<tr>
		<td>
			<table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
				<?php  echo form_open('main/add_booking'); ?>
				<tr height="40px">
					<td colspan="2" class="formHeading">Add New Booking</td>
				</tr>
				<tr>
					<td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
					</td>
				</tr>
				<tr height="10px">
					<td colspan="2"></td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Title</td>
					<td class="formSectionRight" width="68%">
						<input size="35" maxlength="50" class="input" type="text" name="title" required="required"
						value= "<?php echo set_value('title');?>" >
						<?php echo form_error('title'); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>From</td>
					<td class="formSectionRight" width="68%">
						<input id="start_picker" size="35" class="input date" type="text" name="from_date" required="required"
						value= "<?php echo set_value('from_date');?>">
						<input id="start_time" size="35" class="input time" type="text" name="from_time" required="required"
						value= "<?php echo set_value('from_time');?>">
						<?php echo form_error('from_date'); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>To</td>
					<td class="formSectionRight" width="68%">
						<input id="end_picker" size="35" class="input date" type="text" name="to_date"
						value= "<?php echo set_value('to_date');?>" required="required">
						<input id="end_time" size="35" class="input time" type="text" name="to_time"
						value= "<?php echo set_value('to_time');?>" required="required">
						<?php echo form_error('to_date'); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"></td>
					<td class="formSectionRight" width="68%">
						<input id="all_day" type="checkbox" name="all_day" 
						value= "<?php echo set_value('all_day');?>">All Day&nbsp;&nbsp;
						<input id="repeat" type="checkbox" name="repeat" 
						value= "<?php echo set_value('repeat');?>">Repeat... <br />
						<input id="repeat_freq" type="hidden" name="repeat_freq" 
						value= "<?php echo set_value('repeat_freq');?>" />
						<input id="repeat_end" type="hidden" name="repeat_end" 
						value= "<?php echo set_value('repeat_end');?>"/>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Room</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('room', $rooms, $this->input->post('room')); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Client</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('client', $clients, $this->input->post('client')); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%">Description</td>
					<td class="formSectionRight" width="68%">
						<textarea class="input" rows="4" cols="50" type="text" name="description"><?php echo $this->input->post('description');?></textarea>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%">Status</td>
					<td class="formSectionLast" width="68%">
						<input type="radio" name="status" value="0" checked>Tentative&nbsp;&nbsp;
<?php
if ($user->usertype == User::ADMIN) {
?>
						<input type="radio" name="status" value="1">Confirmed&nbsp;&nbsp;
						<input type="radio" name="status" value="2">Rejected
<?php
}
?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td height="30">
						<input value="Continue" class="btnbg" type="submit">&nbsp;&nbsp;
						<input value="Reset" class="btnbg" type="reset">&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<?php echo form_close();?>
			</table>
		</td>
	</tr>
</table>
