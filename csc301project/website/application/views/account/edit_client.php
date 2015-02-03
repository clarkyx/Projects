

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

<table width="550px" class="outter">
    <?php
    $agency_list = array();
    foreach ($clients as $row):
        $agency_list["$row->id"] = "$row->agency";
    endforeach;
    ?>
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <tr height="40px">
                    <td colspan="2" class="formHeading">Edit Client</td>
                </tr>
                <tr>
                    <td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
                    </td>
                </tr>
                <tr height="10px">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Agency Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php

                        echo form_open('account/change_client');
                        echo form_error('partnername');

                        $js = "class='input' value='$client->id' onChange='this.form.submit()'";
                        echo form_dropdown('agency', $agency_list, $client->id, $js);

                        echo form_close();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Program Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php
                        $hidden =array("id" => "$client->id");
                        echo form_open('account/edit_client','',$hidden);
                        echo form_error('programname');
                        ?>
                        <input size="35" maxlength="50" class="input" type="text" name="programname" value="<?php echo $client->program ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Manager Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php echo form_error('manager'); ?>
                        <input size="35" maxlength="50" class="input" type="text" name="manager" value="<?php echo $client->manager ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Manager Position</td>
                    <td class="formSectionRight">
                        <?php echo form_error('managerposition'); ?>
                        <input size="50" maxlength="50" class="input" type="text" name="managerposition" value="<?php echo $client->manager_position ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Facilitator Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php echo form_error('programfc'); ?>
                        <input size="35" maxlength="50" class="input" type="text" name="programfc" value="<?php echo $client->facilitator ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Facilitator Position</td>
                    <td class="formSectionRight">
                        <?php echo form_error('fcposition'); ?>
                        <input size="50" maxlength="50" class="input" type="text" name="fcposition" value="<?php echo $client->facilitator_position ?>" required="required">
                    </td>
                </tr>       
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Category</td>

                    <td class="formSectionRight">
                        <?php
                        $options = array(
                            "Community Information" => "Community Information",
                            "Education" => "Education",
                            "Employment" => "Employment",
                            "Financial" => "Financial",
                            "Food" => "Food",
                            "Health" => "Health",
                            "Housing" => "Housing",
                            "Legal" =>  "Legal",
                            "Mental Health/Counselling" =>  "Mental Health/Counselling",
                            "Parenting/Children Service" => "Parenting/Children Service",
                            "Recreation" => "Recreation",
                            "Settlement" => "Settlement",
                            "Storefront Information" => "Storefront Information",
                            "Transportation" => "Transportation",
                            "Violence/Safety" => "Violence/Safety",
                            "Volunteerism" => "Volunteerism",
                            "Storefront Business Use" => "Storefront Business Use",
                            "Storefront Internal" => "Storefront Internal",
                            "Community Organizing" => "Community Organizing",
                            "Resident Leadership" => "Resident Leadership"
                            );                       
                        $class = "class='input'";

                        echo form_dropdown('category', $options, "$client->category", $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Email Address</td>
                    <td class="formSectionRight">
                        <?php echo form_error('email'); ?>
                        <input size="25" class="input" type="text" name="email" value="<?php echo $client->email?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft">Agreement Status</td>
                    <td class="formSectionRight">
                        <?php echo form_error('agreement_status'); ?>
                        <input size="25" class="input" type="text" name="agreement_status" value="<?php echo $client->agreement_status ?>">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Insurance Status</td>
                    <td class="formSectionRight">
                        <?php echo form_error('insurance'); ?>
                        <input size="25" class="input" type="text" name="insurance" value="<?php echo $client->insurance_status ?>" required="required">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Telephone Number</td>
                    <td class="formSectionRight">
                       <?php echo form_error('phone'); ?>
                      <input size="25" class="input" type="text" name="phone" value="<?php echo $client->phone ?>" required="required">
                     </td>
                </tr>
                <tr>
                    <td class="formSectionLeft">Fax Number</td>
                    <td class="formSectionRight">
                        <?php echo form_error('fax'); ?>
                        <input size="25" class="input" type="text" name="fax" value="<?php echo $client->fax ?>">
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Address</td>
                    <td class="formSectionLast">
                        <?php echo form_error('address'); ?>
                        <textarea cols="37" rows="3" class="input" type="text" name="address">
                            <?php echo $client->address ?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <tr>
                        <td></td>
                        <td height="30">
                            <input value="Save" class="btnbg" type="submit">&nbsp;&nbsp;
                            <?php 
                            echo form_close();
                            echo form_open('account/delete_client','class="inline-block"', $hidden); ?>
                            <input value="Delete" class="btnbg" type="submit" name="delete">&nbsp;&nbsp;&nbsp;
                        </td>
                </tr>
                <?php echo form_close();?>
            </table>
        </td>
    </tr>
</table>


