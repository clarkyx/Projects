<html>

<head>
  <title>Recover Password</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/template.css" />
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>

</head>

<body>
<?php
  	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

 ?>

<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <?php  echo form_open('account/recover_password'); ?>
                <tr height="40px">
                    <td colspan="2" class="formHeading">Recover Password</td>
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
                    <td class="formSectionLast" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="email" required="required">
                        <?php echo form_error('prev'); ?>
                    </td>
                </tr>
                
                <tr>
                    <tr>
                        <td></td>
                        <td height="30">
                            <input value="Recover Password" class="btnbg" id="submit" type="submit">&nbsp;&nbsp;
                        </td>
                </tr>
                <?php echo form_close();?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
