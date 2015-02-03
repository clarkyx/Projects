<script>
function checkPassword() {
var p1 = $("#pass1");
var p2 = $("#pass2");

if (p1.val() == p2.val()) {
            p1.get(0).setCustomValidity("");  // All is well, clear error message
            return true;
        }
        else {
            p1.get(0).setCustomValidity("Passwords do not match");
            return false;
        }
    }
    </script>

    <?php
    $agency = array();
    $client_type =array();
    ?>

<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <?php  echo form_open('account/create_new_user'); ?>
                <tr height="40px">
                    <td colspan="2" class="formHeading">Add New User</td>
                </tr>
                <tr>
                    <td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
                    </td>
                </tr>
                <tr height="10px">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Username</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="username" required="required" 
						value= "<?php echo set_value('username')?>">
                            <?php echo form_error('username'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>First Name</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="first" required="required"
						value= "<?php echo set_value('first')?>">
                            <?php echo form_error('first'); ?>
                        </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Last Name</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="last" required="required"
						value= "<?php echo set_value('last')?>">
                        <?php echo form_error('last'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>E-Mail ID</td>
                    <td class="formSectionRight">
                        <input size="50" maxlength="50" class="input" type="text" name="email" required="required"
						value= "<?php echo set_value('email')?>">
                        <?php echo form_error('email'); ?>
                    </td>
                </tr>      
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>User Type</td>

                    <td class="formSectionRight">
                        <?php
                        $client_type["1"] = "Administrator";
                        $client_type["2"] = "Client";
                        $client_type["3"] = "Frontdesk";

                        $class = "class='input'";
						
                        echo form_dropdown("type", $client_type,  $this->input->post('type'), $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Agency</td>
                    <td class="formSectionRight">
                        <?php
                            foreach ($clients as $row):
                                $agency["$row->id"] = "$row->agency";
                            endforeach;

                            $class = "class='input'";

                            echo form_dropdown("agency", $agency, $this->input->post('agency'), $class);
                        ?>
                    </td>
                </tr>


                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Password</td>
                    <td class="formSectionLast"><label>Password will be sent to user's email</label>
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


