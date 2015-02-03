<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
	$(function() {
		$("#submit").click(function(e){

			
			var p1 = $("#pass1");
			var p2 = $("#pass2");

			if (p1.val() == p2.val()) {
				aler("ok");
				this.form.submit();
			}
			else{
				e.preventDefault();
				alert("password does not match");
				return false;
			}
	});
});

</script>

<?php
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}
?>
<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <?php  echo form_open('account/update_password'); ?>
                <tr height="40px">
                    <td colspan="2" class="formHeading">Update Password</td>
                </tr>
                <tr>
                    <td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
                    </td>
                </tr>
                <tr height="10px">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Current Password</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="password" name="prev" required="required">
                        <?php echo form_error('prev'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>New Password</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="password" id="pass1" name="new" required="required">
                        <?php echo form_error('new'); ?>
                    </td>
                </tr>
                
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>New Password Confirmation</td>
                    <td class="formSectionLast">
                        <input size="35" maxlength="50" class="input" type="password" id="pass2" name="passconf" required="required">
                        <?php echo form_error('passconf'); ?>	
                    </td>
                </tr>
                <tr>
                    <tr>
                        <td></td>
                        <td height="30">
                            <input value="Change Password" class="btnbg" id="submit" type="submit">&nbsp;&nbsp;
                        </td>
                </tr>
                <?php echo form_close();?>
            </table>
        </td>
    </tr>
</table>

