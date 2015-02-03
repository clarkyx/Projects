<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" />
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/template.css" />

  <?php
     if (isset($styles)) {
        $this->load->view($styles);
     }

     if (isset($scripts)) {
        $this->load->view($scripts);
     }
  ?>


</head>

<body>
 <?php $this->load->view('header'); ?>

 <?php $this->load->view('message'); ?>

 <?php $this->load->view($main); ?>

</body>
</html>
