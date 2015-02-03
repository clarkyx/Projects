<img id="imgName" src="<?php echo base_url(); ?>images/mapSMALL.jpg" width="500" height="528" usemap="#usemap" style="margin:50px;margin-left:200px;">

	<map name="usemap">
		<area shape="rect" coords="35,5,140,180" alt="4">
		<area shape="rect" coords="0,230,43,288" alt="3">
		<area shape="rect" coords="189,0,262,95" alt="7">
		<area shape="rect" coords="308,449,380,527" alt="5">
		<area shape="rect" coords="405,300,486,414" alt="6">
		<!--<area shape="rect" coords="380,411,486,527" alt="7">-->
		<area shape="rect" coords="381,230,430,277" alt="1">			
		<area shape="rect" coords="430,230,486,300" alt="2">
	</map>



<script type="text/javascript">
// Create the tooltips only when document ready
$(document).ready(function(){	
   // Use the each() method to gain access to each elements attributes
   var info = '';
   $('area').each(function(){	
        url = "<?= base_url() ?>space/room_info/"+$(this).attr('alt');
        var element = $(this)
   		var syncAjax = $.ajax({
                url: url,
                type: 'POST',

                success : function(data) {

                    info = data;

                    element.qtip({
       	 				content: info, // Use the ALT attribute of the area map
        				position: {
        					corner: {
         						target: 'topRight',
         						tooltip: 'topLeft'
      							} // at the bottom right of...
    					},
    					style: {
    						name: 'cream'
    					}
      				});
                   
                    //alert($(this).attr('alt'));
                }

             
            });
   	});
});
</script>
