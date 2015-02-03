
<script>
function checkPassword() {
    var p1 = $("#pass1");
    var p2 = $("#pass2");

    if (p1.val() == p2.val()) {
                    p1.get(0).setCustomValidity(""); // All is well, clear error message
                    return true;
                }
                else {
                    p1.get(0).setCustomValidity("Passwords do not match");
                    return false;
                }
            }
</script>


<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <?php  echo form_open('account/create_new_client'); ?>
                <tr height="40px">
                    <td colspan="2" class="formHeading">Add New Client</td>
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
                        <input size="35" maxlength="50" class="input" type="text" name="partnername" required="required"
						value= "<?php echo set_value('partnername')?>">
                        <?php echo form_error('partnername'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Program Name</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="programname" required="required"
						value= "<?php echo set_value('programname')?>">
                        <?php echo form_error('programname'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Manager Name</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="manager" required="required"
						value= "<?php echo set_value('manager')?>">
                        <?php echo form_error('manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Manager Position</td>
                    <td class="formSectionRight">
                        <input size="50" maxlength="50" class="input" type="text" name="managerposition" required="required"
						value= "<?php echo set_value('managerposition')?>">
                        <?php echo form_error('managerposition'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Facilitator Name</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="programfc" required="required"
						value= "<?php echo set_value('programfc')?>">
                        <?php echo form_error('programfc'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Facilitator Position</td>
                    <td class="formSectionRight">
                        <input size="50" maxlength="50" class="input" type="text" name="fcposition" required="required"
						value= "<?php echo set_value('fcposition')?>">
                        <?php echo form_error('fcposition'); ?>
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
                        echo form_dropdown('category', $options, $this->input->post('category'), $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Email Address</td>
                    <td class="formSectionRight"><input size="25" class="input" type="text" name="email" required="required"
						value= "<?php echo set_value('email')?>">
                        <?php echo form_error('email'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft">Agreement Status</td>
                    <td class="formSectionRight"><input size="25" class="input" type="text" name="agreement_status"
						value= "<?php echo set_value('agreement_status')?>">
                        <?php echo form_error('agreement_status'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Insurance Status</td>
                    <td class="formSectionRight"><input size="25" class="input" type="text" name="insurance" required="required" value= "<?php echo set_value('insurance')?>">
                        <?php echo form_error('insurance'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Telephone Number</td>
                    <td class="formSectionRight"><input size="25" class="input" type="text" name="phone" required="required"
						value= "<?php echo set_value('phone')?>">
                        <?php echo form_error('phone'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft">Fax Number</td>
                    <td class="formSectionRight"><input size="25" class="input" type="text" name="fax"
						value= "<?php echo set_value('fax')?>">
                        <?php echo form_error('fax'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>Address</td>
                    <td class="formSectionLast">
                        <textarea cols="37" rows="3" class="input" type="text" name="address"
						value= "<?php echo set_value('address')?>"></textarea>
                        <?php echo form_error('address'); ?>
                    </td>
                </tr>
                <tr>
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

