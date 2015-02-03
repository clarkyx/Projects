<script type="text/javascript">
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
<table width="550px" class="outter">
    <?php
    $agency_list = array();
    if("$selectedRoom->id" == ""):
        $agency_list["-1"] = "------------ Select Client -----------";
    endif;
    foreach ($rooms as $row):
        $room_list["$row->id"] = "$row->name";
    endforeach;
    ?>
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <tr height="40px">
                    <td colspan="2" class="formHeading">Room Information</td>
                </tr>
                <tr>
                    <td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are filters to find unbooked room
                    </td>
                </tr>
                <tr height="10px">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"></td>
                    <td class="formSectionRight" width="68%">
                        <input id="all_day" type="number" min="1" pattern="[0-9]*" onkeypress='validate(event)' name="all_day"/>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%">Agency Name</td>
                    <td class="formSectionRight" width="68%">
                        <?php

                        echo form_open('space/change_room');

                        $js = "class='input' value= '$selectedRoom->id' onChange='this.form.submit()'";
                        echo form_dropdown('choosen_room', $room_list, $selectedRoom->id, $js);

                        echo form_close();
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%">Maximum Capacity</td>
                    <td class="formSectionRight" width="68%">
                        <input size="35" maxlength="50" class="input" type="text" name="programname" value="<?php echo $selectedRoom->capacity ?>" required="required">
                    </td>
                </tr>

                <tr>
                    <td class="formSectionLeft">Description</td>
                    <td class="formSectionRight">
                        <textarea cols="37" rows="3" class="input" type="text" name="address" disabled><?php echo $selectedRoom->description ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td class="formSectionLeft">Notes</td>
                    <td class="formSectionLast">
                        <textarea cols="37" rows="3" class="input" type="text" name="address" disabled><?php echo $selectedRoom->notes ?></textarea>
                    </td>
                </tr>
                <tr>
                    <tr>
                        <td></td>
                        <td height="30">
                           
                            
                        </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


