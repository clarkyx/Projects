 <br/>
<h2 class="center">ALL TICKETS</h2>
<hr/>
<br/>
<?php
$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" style="width:100%;text-align:center;">' );
$this->table->set_template($tmpl);

if(!empty($tickets)) echo $this->table->generate($tickets); 

?>
