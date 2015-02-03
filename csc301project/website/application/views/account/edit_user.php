<?php 
if($user->login == "" ){
    $options = array(); 
    $client_type =array();
    $agency = array();
}
?>
<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <tr height="40px">
                    <td colspan="2" class="formHeading">Edit User</td>
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
                    <td class="formSectionRight">
                        <?php

                        foreach ($query as $row):
                            $options["$row->login"] = "$row->login ";
                        endforeach;

                        echo form_open('account/change_user');
                        echo form_error('username');
                        $js = "class='input' value='$user->login' onChange='this.form.submit()'";
                        echo form_dropdown('category', $options, $user->login, $js);
                        echo form_close();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>First Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php
                        $hidden = array("login" => "$user->login", "category" => "$user->login");
                        echo form_open('account/edit_user', '', $hidden);
                        echo form_error('first');
                        ?>
                        <input size="35" maxlength="50" class="input" type="text" name="first" value="<?php echo $user->first ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Last Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php echo form_error('last'); ?>
                        <input size="35" maxlength="50" class="input" type="text" name="last" value="<?php echo $user->last ?>" required="required">
                    </td>
                </tr>   
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>User Type</td>

                    <td class="formSectionRight">
                        <?php
                        $client_type["1"] = "admin";
                        $client_type["2"] = "client";
                        $client_type["3"] = "frontdesk";
                        $user_type = strval($user->usertype);

                        $class = "class='input'";

                        echo form_dropdown("type", $client_type, $user_type, $class);
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

                        $agency_id = strval($user->clientid);
                        $class = "class='input'";

                        echo form_dropdown("agency", $agency, $agency_id, $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>E-Mail ID</td>
                    <td class="formSectionLast">
                        <?php echo form_error('email'); ?>
                        <input size="50" maxlength="50" class="input" type="text" name="email" value="<?php echo $user->email ?>" required="required">
                    </td>
                </tr> 
                <tr>
                    <td></td>
                    <td height="30">     
                        <input value="Save" class="btnbg" type="submit" name="submit">&nbsp;&nbsp;
                        <?php echo form_close(); ?>
                        <?php echo form_open('account/delete_user', 'class="inline-block"', $hidden); ?>
                        <input value="Delete" class="btnbg" type="submit" name="delete">&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <?php echo form_close();?>
            </table>
        </td>
    </tr>
</table>
