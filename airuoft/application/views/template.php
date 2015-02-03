<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AirUofT</title>
<link href="<?php echo base_url();?>css/default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>js/jquery-ui/css/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui/js/jquery-ui.js"></script>
</head>
<body>
<div class="header">
  <div class="container"> <a class="header-title" href="<?php echo base_url();?>">AirUofT</a> </div>
  <div class="nav-container">
    <div class="container">
      <ul id="nav">
        <li> <a href="<?php echo base_url();?>" <?php if($highlight == 'booking') { echo 'class="active"'; } ?> style="border-left:1px solid #ccc;">FLIGHT BOOKING</a> </li>
        <li> <a href="<?php echo base_url();?>admin/index" <?php if($highlight == 'admin') { echo 'class="active"'; } ?>>ADMINISTRATION</a> </li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <?php $this->load->view($main);?>
</div>
<div class="footer">
  <div class="container">
    <p class="center">This web page has been developed as an assignment of the unit CSC 309 Programming on the Web.</p>
  </div>
</div>
</body>
</html>