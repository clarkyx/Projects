
<!DOCTYPE html>

<html>
	<head>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";
		
		$(function(){
			$('body').everyTime(2000,function(){
					if (status == 'waiting') {
						$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Sorry, your invitation to battle was declined!");
									window.location.href = '<?= base_url() ?>arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'battling';
									$('#status').html('Battling ' + otherUser);
								}
								
						});
					}
					var url = "<?= base_url() ?>combat/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							if (msg.length > 0)
								$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
			});

			$('form').submit(function(){
				var arguments = $(this).serialize();
				var url = "<?= base_url() ?>combat/postMsg";
				$.post(url,arguments, function (data,textStatus,jqXHR){
						var conversation = $('[name=conversation]').val();
						var msg = $('[name=msg]').val();
						$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
						});
				return false;
				});	
		});
	
	</script>
	<style>
	.battlefield{
		position: relative;
		border: 1px solid green;
		left:1px;
		top:6.7334px;
		width: 400px;
		height: 400px;
	}
	
		
	div#tank1{
		position:absolute;
		left:0px;
		top:370px;
		background:red;
		width:30px;
		height: 30px;
	}
	
	div#tank2{
		position: absolute;
		left: 370px;
		top: 0px;
		background: blue;
		width: 30px;
		height: 30px;
	}
	
	div#turret2{
		position: absolute;
		left: 380px;
		top: 15px;
		background: green;
		width: 10px;
		height: 30px;
	}
	
	div#turret1{
		position:absolute;
		left:10px;
		top:360px;
		background:green;
		width:10px;
		height: 30px;
	}
	
	div#bullet{
		position:absolute;
		display:none;
		left:0;
		top:0;
		width:5px;
		height:5px;
		background-color:black;
	}
		
	</style>
	<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
    <script type="text/javascript">
		$(function(){
			var duration = 1000;
			var angler = 0;
		 	var allowkeypress = true; 
			var hit = false;
			var otherUser = "<?= $otherUser->login ?>";
			var user = "<?= $user->login ?>";
			var status = "<?= $status ?>";
			$(document).keydown(function(event){
				var keyCode = event.keyCode || event.which;
				var keyMap = {left: 37, up: 38, right: 39, down: 40, rotater: 68, fire: 83};
				switch(keyCode){
					case keyMap.left:
						if(!allowkeypress){}
						else{
							allowkeypress = false;
							setTimeout(function(){allowkeypress = true;},250);
	              			var tank1Left = $( "#tank1" ).offset().left;
							var turret1Left = $( "#turret1" ).offset().left;
							if((tank1Left > 10) && (tank1Left > 10) ){		
								$('#tank1').animate({				
									left: '-=10'
								}, 200);
								$('#turret1').animate({
									left: '-=10'
								}, 200);
							}
							var arguments = $(this).serialize();
							var url = "<?= base_url() ?>combat/upoinfo";
							$.post(url,arguments, function (data,textStatus,jqXHR){	
								var x1 = tank1Left - 10;
								var y1 = tank1Top;
								var x2 = tank1Left + 20;
								var y2 = tank1Top + 30;
								var angle = angler;
								var shot = false;
								var hit = false;
								});	
						}
					break;
					case keyMap.up:
						if(!allowkeypress){}
						else{
							allowkeypress = false;
							setTimeout(function(){allowkeypress = true;},250);
	              			var tank1Top = $( "#tank1" ).offset().top;
							var turret1Top = $( "#turret1" ).offset().top;
							if((tank1Top > 310) &&(turret1Top > 310)){
								$('#tank1').animate({
									top: '-=10'
								}, 200);
								$('#turret1').animate({
									top: '-=10'
								}, 200);
							}
							var arguments = $(this).serialize();
							var url = "<?= base_url() ?>combat/upoinfo";
							$.post(url,arguments, function (data,textStatus,jqXHR){	
								var x1 = tank1Left;
								var y1 = tank1Top - 10;
								var x2 = tank1Left + 30;
								var y2 = tank1Top + 20;
								var angle = angler;
								var shot = false;
								var hit = false;				
								});
						}
					break;
					case keyMap.right:
						if(!allowkeypress){}
						else{
							allowkeypress = false;
							setTimeout(function(){allowkeypress = true;},250);
	              			var tank1Left = $( "#tank1" ).offset().left;
							var turret1Left = $( "#turret1" ).offset().left;
							if((tank1Left < 390) &&(turret1Left < 390)){
								$('#tank1').animate({
									left: '+=10'
								}, 200);
								$('#turret1').animate({
									left: '+=10'
								}, 200);
							}
							var arguments = $(this).serialize();
							var url = "<?= base_url() ?>combat/upoinfo";
							$.post(url,arguments, function (data,textStatus,jqXHR){	
								var x1 = tank1Left + 10;
								var y1 = tank1Top;
								var x2 = tank1Left + 40;
								var y2 = tank1Top + 30;
								var angle = angler;
								var shot = false;
								var hit = false;				
								});					
							
						}
					break;
					case keyMap.down:
						if(!allowkeypress){}
						else{
							allowkeypress = false;
							setTimeout(function(){allowkeypress = true;},250);
	              			var tank1Top = $( "#tank1" ).offset().top;
							var turret1Top = $( "#turret1" ).offset().top;
							if((tank1Top < 680) &&(turret1Top < 680)){
								$('#tank1').animate({
									top: '+=10'
								}, 200);
								$('#turret1').animate({
									top: '+=10'
								}, 200);
							}
							var arguments = $(this).serialize();
							var url = "<?= base_url() ?>combat/upoinfo";
							$.post(url,arguments, function (data,textStatus,jqXHR){	
								var x1 = tank1Left;
								var y1 = tank1Top + 10;
								var x2 = tank1Left + 30;
								var y2 = tank1Top + 40;
								var angle = angler;
								var shot = false;
								var hit = false;				
								});
						}
					break;
					case keyMap.rotater:
						angler += 5;
						if(angler/360 >= 1){
							angler = 0;
						}
						$('#turret1').rotate({
							angle: angler - 5,
							center: ["50%", "100%"],
							animateTo: angler
						});
						var arguments = $(this).serialize();
						var url = "<?= base_url() ?>combat/upoinfo";
						$.post(url,arguments, function (data,textStatus,jqXHR){	
							var x1 = tank1Left;
							var y1 = tank1Top;
							var x2 = tank1Left + 30;
							var y2 = tank1Top + 30;
							var angle = angler;
							var shot = false;
							var hit = false;
							});	
						
					break;
	          	  	case keyMap.fire:
						if(!allowkeypress){}
						else{
						allowkeypress = false;
						setTimeout(function(){allowkeypress = true;},250);	
	              		var tank1Left = $( "#tank1" ).offset().left;
	             	 	var tank1Top = $( "#tank1" ).offset().top;
						var xC = tank1Left+15-10;
						var yC = tank1Top-15-310;
						var arguments = $(this).serialize();
						var url = "<?= base_url() ?>combat/upoinfo";
						$.post(url,arguments, function (data,textStatus,jqXHR){	
							var x1 = tank1Left;
							var y1 = tank1Top;
							var x2 = tank1Left + 30;
							var y2 = tank1Top + 30;
							var angle = angler;
							var shot = true;
							var hit = false;					
							});
						if(angler <= 90){
							while((xC <= 400) && (yC >= 0)){
								xC = xC + Math.tan(angler *(Math.PI/180));
								yC = yC - 1;
							}
							if(xC > 400){
								xC = 400;
							}
							if(yC < 0){
								yC = 0;
							}						
						}					
						if((angler >90) && (angler<= 180)){
							while((xC <= 400) && (yC <= 400)){
								xC = xC + Math.tan((180 - angler) *(Math.PI/180));
								yC = yC + 1;
							}
							if(xC > 400){
								xC = 400;
							}
							if(yC > 400){
								yC = 400;
							}
							
						}						
						if((angler >180) && (angler <= 270)){
							while((xC >= 0) && (yC <= 400)){
								xC = xC - Math.tan((angler-180) *(Math.PI/180));
								yC = yC + 1;
							}
							if(xC < 0){
								xC = 0;
							}
							if(yC > 400){
								yC = 400;
							}	
							
						}
						if((angler >270) && (angler <=360)){
							while((xC >= 0) && (yC <= 400)){
								xC = xC - Math.tan((360-angler) *(Math.PI/180));
								yC = yC - 1;
							}
							if(xC < 0){
								xC = 0;
							}
							if(yC < 0){
								yC = 0;
							}								
						}						
	             		 $( "#bullet" ).offset({left:(tank1Left+15), top:(tank1Top+15)});	
	              		 $( "#bullet" ).css( "display", "block" ).animate({left: xC, top: yC}, 100);
					 }
	            	break;					
				}
			});	
		});
	</script>
	</head> 
<body>  
	<h1>Battle Field</h1>

	<div>
	Hello <?= $user->fullName() ?>  <?= anchor('account/logout','(Logout)') ?>  <?= anchor('account/updatePasswordForm','(Change Password)') ?>
	</div>
	
	<div id='status'> 
	<?php 
		if ($status == "battling")
			echo "Battling " . $otherUser->login;
		else
			echo "Wating on " . $otherUser->login;
	?>
	</div>
	
<?php 
	
	echo form_textarea('conversation');
	
	echo form_open();
	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();
	
?>



	
</body>
<div class="battlefield">
	<div id ="tank1"></div>
	<div id = "turret1"></div>
	<div id = "bullet"></div>
	<div id = "tank2"></div>
	<div id = "turret2"></div>
</div>
</html>

